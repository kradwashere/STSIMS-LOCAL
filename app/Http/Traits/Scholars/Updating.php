<?php

namespace App\Http\Traits\Scholars;

use App\Models\Scholar;
use App\Models\ScholarProfile;
use App\Models\ScholarEducation;
use App\Models\ScholarAddress;
use App\Models\SchoolCourseProspectus;
use App\Http\Resources\Scholar\AddressResource;
use App\Http\Resources\Scholar\EducationResource;
use App\Http\Resources\Scholar\ProfileResource;
use App\Http\Resources\Scholar\SearchResource;

trait Updating { 
    
    public function updating($request){
        $subtype = $request->subtype;
        switch($subtype){
            case 'education':
                $data = $this->education($request);
                $message = 'Education updated successfully.';
            break;
            case 'address':
                $data = $this->address($request);
                $message = 'Address updated successfully.';
            break;
            case 'profile':
                $data = $this->profile($request);
                $message = 'Profile updated successfully.';
            break;
            case 'scholar':
                $data = $this->scholar($request);
                $message = 'Scholar updated successfully.';
            break;
        }

        return back()->with([
            'message' => $message,
            'data' => $data,
            'type' => 'bxs-check-circle',
            'color' => 'success'
        ]); 
    }

    public function education($request){
        $data = ScholarEducation::where('id',$request->education_id)->update($request->except('id','education_id','editable','subtype','type'));
        $data = ScholarEducation::where('id',$request->education_id)->first();
        return new EducationResource($data);
    }

    public function address($request){
        $data = ScholarAddress::where('id',$request->address_id)->update($request->except('id','address_id','editable','subtype','type'));
        $data = ScholarAddress::where('id',$request->address_id)->first();
        return new AddressResource($data);
    }

    public function profile($request){
        $data = ScholarProfile::where('id',$request->address_id)->update($request->except('id','profile_id','editable','subtype','type'));
        $data = ScholarProfile::where('id',$request->address_id)->first();
        return new ProfileResource($data);
    }

    public function scholar($request){
        $data = Scholar::where('id',$request->id)->update($request->except('id','editable','subtype','type'));
        $data = Scholar::with('status')->where('id',$request->id)->first();
        return $data;
    }

    public function course($request){
        $data = ScholarEducation::where('scholar_id',$request->id)->first();

        $pros = SchoolCourseProspectus::where('school_course_id',$request->subcourse_id)->latest()->first();
        $information = [
            'prospectus' => json_decode($pros->subjects)
        ];
        $data->subcourse_id = $request->subcourse_id;
        $data->information = json_encode($information);
        if($data->save()){
            $data =  Scholar::
            with('addresses.region','addresses.province','addresses.municipality','addresses.barangay')
            ->with('profile')
            ->with('program:id,name','subprogram:id,name','category:id,name','status:id,name,type,color,others')
            ->with('education.school.school','education.course','education.level')
            ->where('id',$request->id)
            ->first();
            $data = new SearchResource($data);

            return back()->with([
                'message' => 'Subcourse updated successfully.',
                'data' => $data,
                'type' => 'bxs-check-circle',
                'color' => 'success'
            ]); 
        }   
    }
}