<?php

namespace App\Http\Traits\Enrollment;

use Hashids\Hashids;
use App\Models\Scholar;
use App\Models\ScholarEnrollment;
use App\Http\Resources\DefaultResource;

trait Save { 
    
    public static function enrollment($request){
        $hashids = new Hashids('krad',10);
        $scholar_id = $hashids->decode($request->scholar_id);

        $this->newFinancialGroup($request);
        
        $attachments = [
            'grades' => [],
            'enrollments' => $this->enrollment($request)
        ];
        
        $data = ScholarEnrollment::create(array_merge($request->all(),['scholar_id' => $scholar_id[0],'attachment' => json_encode($attachments), 'added_by' => \Auth::user()->id]));
        $this->level($request);
        $this->createList($data->id,$request);
        // $data = ScholarEnrollment::find($data->id);

        $data = Scholar::with('profile')
        ->with('program:id,name','subprogram:id,name','category:id,name','status:id,name,type,color,others')
        ->with('education.school.school','education.school.semesters','education.course','education.level')
        ->with('enrollments')
        ->whereHas('status',function ($query){
            $query->where('type','Ongoing');
        })
        ->where('id',$scholar_id[0])->first();
        return $data;
    }
}