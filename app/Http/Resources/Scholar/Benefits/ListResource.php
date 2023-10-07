<?php

namespace App\Http\Resources\Scholar\Benefits;

use Illuminate\Http\Resources\Json\JsonResource;

class ListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'account_no' => ($this->account_no == null) ? 'n/a' : $this->account_no,
            'name' => $this->profile->lastname.', '. $this->profile->firstname,
            'program' => $this->program->name,
            'avatar' => ($this->profile->user) ? $this->profile->user->avatar : 'avatar.jpg',
            'enrollments' => $this->enrollments,
            'benefits' => $this->benefits,
            'total' => $this->benefits->sum('amount')
        ];
    }
}
