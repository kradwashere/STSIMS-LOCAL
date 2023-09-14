<?php

namespace App\Http\Resources\School;

use Hashids\Hashids;
use Illuminate\Http\Resources\Json\JsonResource;

class CoursesResource extends JsonResource
{
    public function toArray($request)
    {
        $hashids = new Hashids('krad',10);
        $id = $hashids->encode($this->id);
        
        return [
            'id' => $this->id,
            'code' => $id,
            'years' => $this->years,
            'validity' => $this->validity,
            'certification' => $this->certification,
            'type' => $this->type,
            'course' => $this->course->name,
            'scholars' => $this->course->scholars->count(),
            'course_id' => $this->course->id,
            'prospectuses' => $this->prospectuses
        ];
    }
}
