<?php

namespace App\Http\Traits\Enrollment;

use Hashids\Hashids;
use App\Models\Enrollee;
use App\Models\ListDropdown;
use App\Models\SchoolSemester;
use App\Models\ScholarEducation;
use App\Models\ScholarEnrollment;
use App\Models\ScholarEnrollmentList;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\Scholar\Info\EnrollmentResource;

trait GradeTrait { 
    
    public function grade($request){
        $enrollment = ScholarEnrollment::where('id',$request->enrollment_id)->first();
        $attach = json_decode($enrollment->attachment,true);
        $count = count($attach['grades']);
        
        $attach['grades'] = array_merge($attach['grades'],$this->uploadGrade($request,$enrollment,$count));
        // array_push($attach['grades'],$this->grade($request,$enrollment,$count));
        $enrollment->attachment = $attach;
        $enrollment->save();
        
        $scholar_id = $enrollment->scholar_id;
        $semester_id = $enrollment->semester_id;

        $count = 0;
        $subjects = json_decode($request->lists,true);
        foreach($subjects as $list){
            $enrollment_id = $list['enrollment_id'];
            ($list['grade'] == null) ? $count++ : '';
            $data = ScholarEnrollmentList::where('id',$list['id'])->first();
            $data->grade = $list['grade'];
            $data->is_failed = ($list['grade']== 'F' || $list['grade'] == 5) ? 1 : 0;
            if($data->isDirty('grade')){
                $data->encoded_by = \Auth::user()->id;
            }
            $data->save();
        }

        $data = ScholarEnrollment::where('id',$enrollment_id)->first();
        if($count == 0){
            $data->is_clear = 1;
            $p = Enrollee::where('scholar_id',$scholar_id)->where('school_semester_id',$semester_id)->update(['is_grades_completed' => 1]);
        }else{ 
            $data->is_clear = 0;
        }
        $data->save();

        return back()->with([
            'message' => 'Scholar grades updated successfully. Thanks',
            'data' =>  new EnrollmentResource($data),
            'type' => 'bxs-check-circle'
        ]); 
    }

    public function uploadGrade($request,$enrollment,$count){
        if($request->hasFile('files'))
        {   
            $level = ListDropdown::where('id',$enrollment->level_id)->pluck('name');
            $semester = SchoolSemester::where('id',$enrollment->semester_id)->first();
            $academic_year = $semester['academic_year'];
            $semester_name = $semester['semester']['name'];
            $code = $request->scholar_id;
            
            $files = $request->file('files');   
            foreach ($files as $file) {
                if($count == 0){
                    $file_name = 'grades_'.$level[0].'-'.$academic_year.'-'.$semester_name.'.'.$file->getClientOriginalExtension();
                }else{
                    $file_name = 'grades_'.$level[0].'-'.$academic_year.'-'.$semester_name.'-'.$count.'.'.$file->getClientOriginalExtension();
                    $count++;
                }
                $file_path = $file->storeAs('uploads/'.$code.'/Grades', $file_name, 'public');

                $attachment[] = [
                    'name' => $file_name,
                    'file' => $file_path,
                    'added_by' => \Auth::user()->id,
                    'created_at' => date('M d, Y g:i a', strtotime(now()))
                ];
            }
            return $attachment;
        }
    }

    public function lock($request){
        if($request->editable){
            $this->unlockGrade($request);
        }else{
            $this->lockGrade($request);
        }
    }

    public function unlockGrade($request){
        $data = ScholarEnrollment::where('id',$request->id)->first();
        $data->update($request->except('editable'));

        return back()->with([
            'message' => 'Scholar grades unlocked successfully. Thanks',
            'data' =>  new EnrollmentResource($data),
            'type' => 'bxs-check-circle'
        ]); 
    }

    public function lockGrade($request){
        $data = ScholarEnrollment::where('id',$request->id)->first();
        $data->update($request->except('editable'));
        if($data->is_clear){
            $scholar_id =  $data->scholar_id;
            $semester_id =  $data->semester_id;

            $p = Enrollee::where('scholar_id',$scholar_id)->where('school_semester_id',$semester_id)->update(['is_grades_completed' => 1]);

            $p = ScholarEducation::with('subcourse')->where('scholar_id',$scholar_id)->first();
            $years = $p->subcourse->years; 
            $semesters = 3;

            $prospectus = json_decode($p->information,true);

            for($x = 0; $x < $years; $x++){
                for($y = 0; $y < $semesters; $y++){
                    foreach($request->lists as $list){
                        $code = $list['code']; $is_lab = $list['is_lab'];
                        $results = array_filter($prospectus['prospectus'][$x]['semesters'][$y]['courses'], function($people) use ($code,$is_lab) {
                            if(array_key_exists("code",$people)){
                                return $people['code'] == $code && $people['is_lab'] == $is_lab;
                            }else{
                                return $results = [];
                            }
                        });
                        if(!empty($results)){
                            $key = array_keys($results)[0];
                            if($list['grade'] != null){
                                ($list['grade'] == 'F' || $list['grade'] == 'f' || $list['grade'] == 5) ? $failed = 1 : $failed = 0;
                                if(array_key_exists("is_failed",$prospectus['prospectus'][$x]['semesters'][$y]['courses'][$key])){
                                    if($prospectus['prospectus'][$x]['semesters'][$y]['courses'][$key]['is_failed']){
                                        $grades = $prospectus['prospectus'][$x]['semesters'][$y]['courses'][$key]['grades'];
                                        array_push($grades,strtoupper($list['grade']));
                                        $prospectus['prospectus'][$x]['semesters'][$y]['courses'][$key]['grades'] = $grades;
                                    }
                                }else{
                                    if($failed){
                                        $grades = [];
                                        array_push($grades,strtoupper($list['grade']));
                                        $prospectus['prospectus'][$x]['semesters'][$y]['courses'][$key]['grades'] = $grades;
                                    }else{
                                        $prospectus['prospectus'][$x]['semesters'][$y]['courses'][$key]['grade'] = $list['grade'];
                                    }
                                }
                                $prospectus['prospectus'][$x]['semesters'][$y]['courses'][$key]['is_failed'] = $failed;
                            }
                        }
                    }
                }
            }
            $p->information = $prospectus;
            $p->save();   
        }
        return back()->with([
            'message' => 'Scholar grades locked successfully. Thanks',
            'data' =>  new EnrollmentResource($data),
            'type' => 'bxs-check-circle'
        ]); 
    }
}