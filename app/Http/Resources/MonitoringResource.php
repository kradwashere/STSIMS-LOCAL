<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MonitoringResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'spas_id' => $this->spas_id,
            'firstname' => ucwords(strtolower($this->profile->firstname)),
            'middlename' => ucwords(strtolower($this->profile->middlename)),
            'lastname' => ucwords(strtolower($this->profile->lastname)),
            'avatar' => 'avatar.jpg'
        ];
    }
}
