<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'year' => $this->year,
            'information' => json_decode($this->information),
            'signatories' => json_decode($this->signatories),
            'agency' => $this->agency,
            'api_key' => $this->api_key
        ];
    }
}
