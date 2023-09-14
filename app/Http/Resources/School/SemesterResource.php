<?php

namespace App\Http\Resources\School;

use Illuminate\Http\Resources\Json\JsonResource;

class SemesterResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'academic_year' => $this->academic_year,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'semester' => $this->semester,
            'is_active' => $this->is_active
        ];
    }
}
