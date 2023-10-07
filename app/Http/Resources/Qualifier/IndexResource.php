<?php

namespace App\Http\Resources\Qualifier;

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
            'program' => $this->program,
            'type' => $this->type,
            'subprogram' => $this->subprogram,
            'status' => $this->status,
            'qualified_year' => $this->qualified_year,
            'profile' => new ProfileResource($this->profile), 
            'address' => new AddressResource($this->address),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
