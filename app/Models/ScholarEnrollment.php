<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScholarEnrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'semester_id', 'level_id', 'scholar_id', 'added_by', 'start_at', 'end_at', 'is_clear', 'is_locked', 'attachment'
    ];

    public function lists()
    {
        return $this->hasMany('App\Models\ScholarEnrollmentList', 'enrollment_id');
    } 
    
    public function scholar()
    {
        return $this->belongsTo('App\Models\Scholar', 'scholar_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'added_by', 'id');
    }

    public function level()
    {
        return $this->belongsTo('App\Models\ListDropdown', 'level_id', 'id');
    }

    public function failed()
    {
    return $this->hasMany('App\Models\ScholarEnrollmentList', 'enrollment_id')->where('is_failed',1)->count();
    }

    public function empty()
    {
    return $this->hasMany('App\Models\ScholarEnrollmentList', 'enrollment_id')->where('grade',NULL)->count();
    }

    public function semester()
    {
        return $this->belongsTo('App\Models\SchoolSemester', 'semester_id', 'id');
    }

    public function getStartAtAttribute($value)
    {
        return date('M Y', strtotime($value));
    }

    public function getEndAtAttribute($value)
    {
        return date('M Y', strtotime($value));
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
