<?php

namespace App\Http\Resources\Accounting;

use Illuminate\Http\Resources\Json\JsonResource;

class DisbursementResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'expense' => $this->expense,
            'created_at' => $this->created_at,
            'remarks' => $this->remarks,
            'added_by' => $this->user->profile->firstname.' '.$this->user->profile->lastname,
        ];
    }
}
