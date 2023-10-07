<?php

namespace App\Http\Resources\Scholar;

use Hashids\Hashids;
use App\Http\Resources\Scholar\Info\EnrollmentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchResource extends JsonResource
{
    public function toArray($request)
    {
        $hashids = new Hashids('krad',10);
        $id = $hashids->encode($this->id);
        
        return [
            'id' => $this->id,
            'code' => $id,
            'account_no' => ($this->account_no == null) ? 'n/a' : $this->account_no,
            'spas_id' => ($this->spas_id == null) ? 'n/a' : $this->spas_id,
            'awarded_year' => $this->awarded_year,
            'status' => $this->status,
            'program' => $this->program,
            'profile' => new ProfileResource($this->profile), 
            'education' =>  new EducationResource($this->education),
            'enrollments' => EnrollmentResource::collection($this->enrollments),
            'semesters' =>  $this->education->school->semesters,
        ];
    }
}
