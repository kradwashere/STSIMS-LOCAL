<?php

namespace App\Http\Resources\Scholar;

use Hashids\Hashids;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
{
    public function toArray($request)
    {
        $hashids = new Hashids('krad',10);
        $id = $hashids->encode($this->id);

        return [
            'code' => $id,
            'id' => $this->id,
            'spas_id' => $this->spas_id,
            'account_no' => $this->account_no,
            'program' => $this->program->name,
            'subprogram' => $this->subprogram->name,
            'category' => $this->category->name,
            'status' => $this->status,
            'awarded_year' => $this->awarded_year,
            'is_completed' => $this->is_completed,
            'user' => ($this->user != null) ? new UserResource($this->user) : null,
            'profile' => new ProfileResource($this->profile), 
            'addresses' => AddressResource::collection($this->addresses),
            'education' =>  new EducationResource($this->education),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
