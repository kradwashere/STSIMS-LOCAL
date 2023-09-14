<?php

namespace App\Http\Resources\Scholar;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    public function toArray($request)
    {
        $info = json_decode($this->information);
        $barangay = ($this->barangay == null) ? (isset($info->barangay)) ? $info->barangay.', ' : '' : $this->barangay->name.', ';
        $municipality = ($this->municipality == null) ? $info->municipality.', ' : $this->municipality->name.', ';
        $province = ($this->province == null) ? $info->province : $this->province->name;

        $name = ucwords(strtolower($barangay.$municipality.$province));

        return [
            'id' => $this->id,
            'name' => $name,
            'address' => $this->address,
            'region' => $this->region,
            'province' => $this->province,
            'municipality' => $this->municipality,
            'barangay' => $this->barangay,
            // 'has_region' => ($this->region_code == null) ? false : true,
            // 'has_province' => ($this->province_code == null) ? false : true,
            // 'has_municipality' => ($this->municipality_code == null) ? false : true,
            // 'has_barangay' => ($this->barangay_code == null) ? false : true,
            'is_permanent' => $this->is_permanent,
            'is_completed' => $this->is_completed,
            'info' => $info
        ];
    }
}
