<?php

namespace App\Http\Resources\Scholar\Info;

use App\Models\ScholarEnrollment;
use App\Models\SchoolSemester;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolResource extends JsonResource
{
    public function toArray($request)
    {
        $semester = SchoolSemester::with('semester')->where('school_id',$this->id)->where('is_active',1)->first();
       
        if($semester){
            $enrolled = ScholarEnrollment::where('semester_id',$semester->id)->where('scholar_id',$this->scholar_id)->first();
        }else{
            $enrolled = null;
        }

        return [
            'id' => $this->id,
            'scholar_id' => $this->scholar_id,
            'name' => ucwords(strtolower($this->school->name)),
            'class' => $this->school->class->name,
            'avatar' => $this->school->avatar,
            'shortcut' => $this->school->shortcut,
            'campus' => ($this->campus == 'MAIN') ?  ucwords(strtolower($this->campus)) : ucwords(strtolower($this->campus)),
            'address' => ucwords($this->address),
            'semester' => ($semester) ? $semester : false,
            'is_enrolled' => ($enrolled) ? true : false,
            'gradings' => $this->gradings
        ];
    }
}
