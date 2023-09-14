<?php

namespace App\Http\Resources\School;

use Hashids\Hashids;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
{
    public function toArray($request)
    {
        $hashids = new Hashids('krad',10);
        $code = $hashids->encode($this->id);

        $address = ($this->address) ? ucwords(strtolower($this->address)).', ' : '';
        $region = ($this->region) ? $this->region->region : '';
        $province = ($this->province) ? $this->province->name.', ' : '';
        $municipality = ($this->municipality) ? $this->municipality->name.', ' : '';

        return [
            'id' => $this->id,
            'code' => $code,
            'is_main' => $this->is_main,
            'is_active' => $this->is_active,
            'term' =>($this->term) ? $this->term->name : '',
            'grading' => ($this->grading) ? $this->grading->name : '',
            'class' => $this->school->class->name,
            'avatar' => $this->school->avatar,
            'name' => ucwords(strtolower($this->school->name)),
            'shortcut' => $this->school->shortcut,
            'campus' => ucwords(strtolower($this->campus)),
            'oldname' => ucwords(strtolower($this->oldname)),
            'courses' => CoursesResource::collection($this->courses),
            'semesters' => SemesterResource::collection($this->semesters),
            'address' => $address.$municipality.$province.$region,
            'gradings' => $this->gradings,
            'display' => ($this->is_main) ? ucwords(strtolower($this->school->name)) : ucwords(strtolower($this->school->name)).' - '.ucwords(strtolower($this->campus)),
        ];
    }
}
