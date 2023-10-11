<?php

namespace App\Http\Resources\Staff;

use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
{
    public function toArray($request)
    {
        if($this->profile->profileable){
            $this->profile->profileable->type = $this->profile->profileable_type;
        }
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'role' => $this->role,
            'avatar' => $this->avatar,
            'temp_password' => $this->temp_password,
            'is_active' => $this->is_active,
            'profile' => new ProfileResource($this->profile),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
