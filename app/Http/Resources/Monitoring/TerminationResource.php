<?php

namespace App\Http\Resources\Monitoring;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\MonitoringResource;

class TerminationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'academic_year' => $this->semester->academic_year,
            'semester' => $this->semester->semester->name,
            'level' => $this->level->name,
            'scholar' => new MonitoringResource($this->scholar),
            'status' => $this->scholar->status,
            'subjects' => $this->lists,
        ];
    }
}
