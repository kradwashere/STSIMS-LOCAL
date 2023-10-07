<?php

namespace App\Http\Resources\Accounting;

use Illuminate\Http\Resources\Json\JsonResource;

class AllotmentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'total' => $this->total(),
            'check_no' => $this->check_no,
            'credited_at' => $this->credited_at,
            'checked_at' => $this->checked_at,
            'created_at' => $this->created_at,
            'remarks' => $this->remarks,
            'added_by' => $this->user->profile->firstname.' '.$this->user->profile->lastname,
            'lists' => SuballotmentResource::collection($this->lists)
        ];
    }
}
