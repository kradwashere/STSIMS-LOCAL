<?php

namespace App\Http\Resources\School\Search;

use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
{
    public function toArray($request)
    {
        $name = ucwords(strtolower($this->school->name));
        $campus = ($this->is_main) ? '' : ' - '.ucwords(strtolower($this->campus)) ;
        return [
            'id' => $this->id,
            'name' => $name.' '.$campus,
            'courses' => CourseResource::collection($this->courses),
            'region' => $this->assigned_region
        ];
    }
}
