<?php

namespace App\Http\Resources\Scholar\Info;

use Illuminate\Http\Resources\Json\JsonResource;

class SemesterResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->semester->id,
            'year' => $this->semester->year,
            'academic_year' => $this->semester->academic_year,
            'start_at' => $this->semester->start_at,
            'end_at' => $this->semester->end_at,
            'semester' => $this->semester->semester->name,
            'type' => $this->semester->semester->others,
        ];
    }
}
