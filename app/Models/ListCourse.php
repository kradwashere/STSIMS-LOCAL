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
    
    public function getNameAttribute($value)
    {
        $wordsToReplace = array("BEED", "BS", "BSE");
        $inputString = ucwords(strtolower($value));
        foreach ($wordsToReplace as $word) {
            $inputString = str_ireplace($word, strtoupper($word), $inputString);
        }
        return $inputString;
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
