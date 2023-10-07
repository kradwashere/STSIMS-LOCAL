<?php

namespace App\Http\Resources\Scholar\Info;

use Illuminate\Http\Resources\Json\JsonResource;

class ListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'attachment' => json_decode($this->attachment,true),
            'grades' => $this->lists,
            'benefits' => $this->semester->benefits,
            'level' => $this->level,
            'semester' => $this->semester->semester,
            'status' => $this->enrollee,
            'academic_year' => $this->semester->academic_year,
            'start_at' => $this->semester->start_at,
            'end_at' => $this->semester->end_at,
        ];
    }
}
