<?php

namespace App\Http\Traits\Schools;

use DB;
use App\Models\Enrollee;
use App\Models\Release;
use App\Models\SchoolGrading;
use App\Models\SchoolSemester;
use App\Models\SchoolCourseProspectus;
use App\Models\ScholarEnrollment;
use App\Models\ScholarEnrollmentList;

trait Truncate { 


    public function truncate($request){
        $subtype = $request->subtype;

        switch($subtype){
            case 'schools':
                $this->schools();
            break;
        }
    }

    public function schools(){
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        SchoolSemester::truncate();
        SchoolGrading::truncate();
        SchoolCourseProspectus::truncate();
        ScholarEnrollment::truncate();
        ScholarEnrollmentList::truncate();
        Enrollee::truncate();
        Release::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        return back()->with([
            'data' => true,
            'message' => 'Database Truncated Succesfully',
            'type' => 'bxs-check-circle',
            'color' => 'success'
        ]);
    }

    
}