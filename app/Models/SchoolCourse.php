<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id', 'course_id', 'type' , 'years', 'validity', 'certification'
    ];

    public function getTypeAttribute($value)
    {
        return ucwords($value);
    }

    public function course()
    {
        return $this->belongsTo('App\Models\ListCourse', 'course_id', 'id');
    }

    public function school()
    {
        return $this->belongsTo('App\Models\SchoolCampus', 'school_id', 'id');
    }

    public function prospectuses()
    {
        return $this->hasMany('App\Models\SchoolCourseProspectus', 'school_course_id')->orderBy('id','desc');
    } 

}
