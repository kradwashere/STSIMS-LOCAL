<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolCourseProspectus extends Model
{
    use HasFactory;

    protected $fillable = [
        'subjects', 'school_year', 'is_ative', 'is_completed','school_course_id', 'added_by'
    ];
    
    protected $guarded=[];
    
    public function course()
    {
        return $this->belongsTo('App\Models\SchoolCourse', 'school_course_id', 'id');
    }

    public function added()
    {
        return $this->belongsTo('App\Models\User', 'added_by', 'id');
    }
}
