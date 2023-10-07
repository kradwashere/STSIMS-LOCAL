<?php

namespace App\Http\Traits\Enrollment;

use Hashids\Hashids;
use App\Models\Enrollee;
use App\Models\ListPrivilege;
use App\Models\ListDropdown;
use App\Models\Scholar;
use App\Models\ScholarCourse;
use App\Models\ScholarBenefit;
use App\Models\ScholarEducation;
use App\Models\ScholarEnrollment;
use App\Models\ScholarEnrollmentList;
use App\Models\SchoolSemester;
use App\Models\SchoolCourseProspectus;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\Scholar\SearchResource;

trait EnrollmentTrait { 
    
    public function enrollment($request){
        $hashids = new Hashids('krad',10);
        $scholar_id = $hashids->decode($request->scholar_id);

       
        
        $attachments = [
            'grades' => [],
            'enrollments' => $this->uploadEnrollment($request)
        ];
        
        $data = ScholarEnrollment::create(array_merge($request->all(),['scholar_id' => $scholar_id[0],'attachment' => json_encode($attachments), 'added_by' => \Auth::user()->id]));
        $this->level($request);
        $this->createList($data->id,$request);

        if($data){
            $this->newFinancialGroup($request,$data->id);
        }

        $data = Scholar::with('profile')
        ->with('program:id,name','subprogram:id,name','category:id,name','status:id,name,type,color,others')
        ->with('education.school.school','education.school.semesters','education.course','education.level')
        ->with('enrollments')
        ->whereHas('status',function ($query){
            $query->where('type','Ongoing');
        })
        ->where('id',$scholar_id[0])->first();

        return back()->with([
            'message' => 'Scholar enrolled successfully. Thanks',
            'data' =>  new SearchResource($data),
            'type' => 'bxs-check-circle'
        ]); 
    }

    public function createList($id,$request) 
    {
        $lists = json_decode($request->lists,true);
        foreach($lists as $key=>$list){
            $options = [];
            ScholarEnrollmentList::create(array_merge($list,[
                'options' => json_encode($options) ,
                'enrollment_id' => $id,
                'encoded_by' =>  \Auth::user()->id
            ]));
        }
    }

    public function check($request)
    {
        $count = ScholarCourse::where('scholar_id',$request->scholar_id)->count();
        if($count == 0){
            $pros = SchoolCourseProspectus::where('school_course_id',$request->subcourse)->first();
            $information = [
                'prospectus' => json_decode($pros->subjects)
            ];

            $data = new ScholarCourse;
            $data->scholar_id = $request->scholar_id;
            $data->subcourse_id = $request->subcourse;
            $data->information = json_encode($information);
            $data->save();
        }
    }

    public function level($request){
        $hashids = new Hashids('krad',10);
        $scholar_id = $hashids->decode($request->scholar_id);
        $data = ScholarEducation::where('scholar_id',$scholar_id[0])->first();
        ($data->level_id != $request->level_id) ? $data->level_id = $request->level_id : '';
        $data->save();
    }

    public function newFinancialGroup($request,$id){
        $hashids = new Hashids('krad',10);
        $scholar_id = $hashids->decode($request->scholar_id);

        $semester_id = $request->semester_id;
        $semester = SchoolSemester::where('id',$semester_id)->first();

        $month = $semester->start_at;

        $data = new Enrollee;
        $data->school_semester_id = $semester_id;
        $data->scholar_id = $scholar_id[0];
        $data->enrollment_id = $id;
        if($data->save()){
            // $list_benefits = ListPrivilege::whereNotIn('name',['Tuition & Other School Fees','Thesis Allowance','Transportation Allowance','Graduation Allowance','Group Accident Insurance', 'Others'])->get();
            $list_benefits = ListPrivilege::where('is_reimburseable',0)->get();
            $type = ScholarEducation::with('school.term')->where('scholar_id',$scholar_id[0])->first();
            $type = $type->school->term->name;
            $others = $data->semester->semester->others;

            switch($type){
                case 'Semester': 
                    $div = 2;
                break;
                case 'Trimester':
                    $div = 3;
                break;
                case 'Quarter Term':
                    $div = 4;
                break;
            }
    
            foreach($list_benefits as $benefit){
                $attachment = [];
                $amount = ($others != 'summer') ? $benefit['regular_amount'] : $benefit['summer_amount'];
                if($others != 'summer'){
                    $total = $amount / (($benefit['type'] == 'Term') ? $div : 1);
                }else{
                    $total = $amount;
                }
                $wew = [
                    'benefit_id' => $benefit['id'],
                    'scholar_id' => $scholar_id[0],
                    'amount' => $total,
                    'release_type' => 'Full',
                    'month' => $month,
                    'status_id' => 11,
                    'school_semester_id' => $semester_id,
                    'attachment' => json_encode($attachment)
                ];
    
                if($benefit['id'] == 1){
                    $number = ($others != 'summer') ? 5 : 2; 
                    for($x = 0; $x < $number; $x++){
                        $list = ScholarBenefit::create($wew);
                        $wew['month'] = date('Y-m-d', strtotime($wew['month']. ' + 1 months'));
                    }
                }else if($benefit['name'] == 'Clothing Allowance'){
                    $count = ScholarBenefit::where('scholar_id',$scholar_id[0])->where('benefit_id',$benefit['id'])->count();
                    ($count == 0) ? $list = ScholarBenefit::create($wew) : '';
                }else{
                    $list = ScholarBenefit::create($wew);
                }
            }
        }
    }

    public function switch($request){
        $from = $request->from;
        $to = $request->to;
        $p = ScholarEducation::with('subcourse')->where('scholar_id',$request->scholar_id)->first();
        $years = $p->subcourse->years; 
        $semesters = 3;
        $prospectus = json_decode($p->information,true);
    
        for($x = 0; $x < $years; $x++){
            for($y = 0; $y < $semesters; $y++){
                $result = array_filter($prospectus['prospectus'][$x]['semesters'][$y]['courses'], function($all) use ($from) {
                    return $all['code'] == $from['code'];
                });
                if(!empty($result)){
                    for($z = 0; $z < $years; $z++){
                        for($w = 0; $w < $semesters; $w++){
                            $result2 = array_filter($prospectus['prospectus'][$z]['semesters'][$w]['courses'], function($all) use ($to) {
                                return $all['code'] == $to['code'] && $all['is_lab'] == $to['is_lab'];
                            });
                            if(!empty($result2)){
                                $key = array_keys($result)[0];
                                $key2 = array_keys($result2)[0];
                                $prospectus['prospectus'][$x]['semesters'][$y]['courses'][$key] = $result2[$key2];
                                $prospectus['prospectus'][$z]['semesters'][$w]['courses'][$key2] = $result[$key];
                                break;
                            }
                        }
                    }
                    break;
                }
            }
        }
        $p->information = $prospectus;
        $p->save();   

        return back()->with([
            'message' => 'Subject switched successfully. Thanks',
            'data2' =>  new DefaultResource($p),
            'type' => 'bxs-check-circle'
        ]); 
    }

    public function uploadEnrollment($request){
        if($request->hasFile('files'))
        {   
            $level = ListDropdown::where('id',$request->level_id)->pluck('name');
            $semester = SchoolSemester::where('id',$request->semester_id)->first();
            $academic_year = $semester['academic_year'];
            $semester_name = $semester['semester']['name'];
            // dd($level[0].'-'.$academic_year.'-'.$semester_name);
            $code = $request->scholar_id;
            $files = $request->file('files');   
            foreach ($files as $key=>$file) {
                if($key == 0){
                    $file_name = $level[0].'-'.$academic_year.'-'.$semester_name.'.'.$file->getClientOriginalExtension();
                }else{
                    $file_name = $level[0].'-'.$academic_year.'-'.$semester_name.'-'.$key.'.'.$file->getClientOriginalExtension();
                }
              
                $file_path = $file->storeAs('uploads/'.$code.'/Enrollments', $file_name, 'public');
            }
            return $attachment = [
                'name' => $file_name,
                'file' => $file_path,
                'added_by' => \Auth::user()->id,
                'created_at' => date('M d, Y g:i a', strtotime(now()))
            ];
        }
    }
}