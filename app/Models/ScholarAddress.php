<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScholarAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'region_code', 
        'province_code', 
        'municipality_code', 
        'barangay_code', 
        'address', 
        'district', 
        'is_completed',
        'is_permanent',
        'is_within',
        'scholar_id',
        'information',
        'is_synced'
    ];

    public function scholar()
    {
        return $this->belongsTo('App\Models\Scholar', 'scholar_id', 'id');
    }

    public function region()
    {
        return $this->belongsTo('App\Models\LocationRegion', 'region_code', 'code');
    }

    public function province()
    {
        return $this->belongsTo('App\Models\LocationProvince', 'province_code', 'code');
    }

    public function municipality()
    {
        return $this->belongsTo('App\Models\LocationMunicipality', 'municipality_code', 'code');
    }

    public function barangay()
    {
        return $this->belongsTo('App\Models\LocationBarangay', 'barangay_code', 'code');
    }

    public function getAddressAttribute($value){
        return ucwords(strtolower($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }
}
