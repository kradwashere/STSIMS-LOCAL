<?php

namespace App\Http\Traits\Monitoring;

use App\Models\Release;
use App\Models\Enrollee;
use App\Models\Scholar;
use App\Models\ScholarBenefit;

trait Save { 
    
    public function checked($request){
        $releases = Release::where('is_checked',0)->pluck('id');
        $scholars = ScholarBenefit::whereIn('release_id',$releases)->groupBy('scholar_id')->pluck('scholar_id');
        foreach($scholars as $scholar){
            $enrollees = Enrollee::where('scholar_id',$scholar)->where('is_benefits_released',0)->get();
            foreach($enrollees as $enrollee){
                foreach($releases as $release){
                    $benefits = ScholarBenefit::where('school_semester_id',$enrollee->school_semester_id)->where('scholar_id',$scholar)->where('status_id','!=',13)->count();
                    if($benefits == 0){
                        if($enrollee->is_grades_completed){
                            $e = Enrollee::where('scholar_id',$scholar)->where('school_semester_id',$enrollee->school_semester_id)->update(['is_benefits_released' => 1,'is_completed' => 1]);
                        }else{
                            $e = Enrollee::where('scholar_id',$scholar)->where('school_semester_id',$enrollee->school_semester_id)->update(['is_benefits_released' => 1]);
                        }
                    }
                    Release::where('id',$release)->update(['is_checked' => 1]);
                }
            }
        }
    }

    public function terminate($request){
        switch($request->option){
            case 2:
                Scholar::where('id',$request->scholar_id)->update(['status_id' => 8]);
            break;
            case 3:

            break;
        }
        Enrollee::where('enrollment_id',$request->enrollment_id)->update(['is_checked' => 1]);
    }
    
}