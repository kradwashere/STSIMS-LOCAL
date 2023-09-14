<?php

namespace App\Http\Controllers;

use App\Models\LocationRegion;
use App\Models\LocationProvince;
use App\Models\LocationMunicipality;
use App\Models\LocationBarangay;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;

class ListController extends Controller
{
    public function regions()
    {
        $data = LocationRegion::orderBy('id','ASC')->get();
        return DefaultResource::collection($data);
    }

    public function provinces($id = null)
    {
        $data = LocationProvince::where('region_code',$id)->orderBy('name','ASC')->get();
        return DefaultResource::collection($data);
    }

    public function municipalities($id = null)
    {
        $data = LocationMunicipality::where('province_code',$id)->orderBy('name','ASC')->get();
        return DefaultResource::collection($data);
    }

    public function barangays($id = null)
    {
        $data = LocationBarangay::where('municipality_code',$id)->orderBy('name','ASC')->get();
        return DefaultResource::collection($data);
    }
}
