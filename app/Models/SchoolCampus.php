<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolCampus extends Model
{
    use HasFactory;

    protected $fillable = [
        'campus',
        'shortcut',
        'address',
        'oldname',
        'is_main',
        'term_id',
        'grading_id',
        'school_id',
        'municipality_code',
        'province_code',
        'region_code',
        'assigned_code'
    ];

    public function assigned()
    {
        return $this->belongsTo('App\Models\LocationRegion', 'assigned_region', 'code');
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

    public function school()
    {
        return $this->belongsTo('App\Models\School', 'school_id', 'id');
    }

    public function courses()
    {
        return $this->hasMany('App\Models\SchoolCourse', 'school_id');
    } 

    public function semesters()
    {
        return $this->hasMany('App\Models\SchoolSemester', 'school_id');
    } 

    public function term()
    {
        return $this->belongsTo('App\Models\ListDropdown', 'term_id', 'id');
    }

    public function grading()
    {
        return $this->belongsTo('App\Models\ListDropdown', 'grading_id', 'id');
    }

    public function profile()
    {
        return $this->morphOne('App\Models\UserProfile', 'profileable');
    }

    public function scholars()
    {
        return $this->hasMany('App\Models\ScholarEducation', 'school_id');
    } 

    public function gradings()
    {
        return $this->hasMany('App\Models\SchoolGrading', 'school_id');
    } 

    public function getCampusAttribute($value){
        return strtoupper($value);
    }

    public function setCampusAttribute($value){
        $this->attributes['campus'] = strtoupper($value);
    }

    public function setAddressAttribute($value){
        $this->attributes['address'] = strtoupper($value);
    }
    public function setOldnameAttribute($value){
        $this->attributes['oldname'] = strtoupper($value);
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
