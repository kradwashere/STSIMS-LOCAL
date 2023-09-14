<?php

namespace App\Http\Resources\Staff;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->lastname.', '.$this->firstname.' '.$this->middlename.'.',
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'middlename' => $this->middlename,
            'gender' => $this->gender,
            'gender_color' =>($this->gender == 'M') ? 'info' : 'warning',
            'mobile' => $this->mobile,
            'type' => new TypeResource($this->profileable),
        ];
    }
}
