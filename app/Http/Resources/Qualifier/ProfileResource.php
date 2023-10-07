<?php

namespace App\Http\Resources\Qualifier;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'avatar' => 'avatar.jpg',
            'name' => ucwords(strtolower($this->lastname)).', '.ucwords(strtolower($this->firstname)).' '.ucwords(strtolower($this->suffix)).' '.ucwords(strtolower($this->middlename)).'.',
            'firstname' => ucwords(strtolower($this->firstname)),
            'middlename' => ucwords(strtolower($this->middlename)),
            'lastname' =>ucwords(strtolower( $this->lastname)),
            'suffix' => ($this->suffix == null) ? '' : $this->suffix,
            'sex' => $this->sex,
            'birthday' => ($this->birthday == null) ? '' : $this->birthday,
            'contact_no' => ($this->contact_no == null) ? 'n/a' : $this->contact_no
        ];
    }
}
