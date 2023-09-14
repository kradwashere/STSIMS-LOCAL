<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'abbreviation', 'others', 'is_active'
    ];
    
    public function scholars()
    {
        return $this->hasMany('App\Models\ScholarEducation', 'course_id');
    } 

    public function lists()
    {
        return $this->hasMany('App\Models\SchoolCourse', 'course_id');
    } 
    
    // public function getNameAttribute($value)
    // {
    //     return ucwords(strtolower($value));
    // }

    public function getUpdatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }
}
