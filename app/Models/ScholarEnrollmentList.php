<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScholarEnrollmentList extends Model
{
    use HasFactory;

    protected $fillable = [
        'code' , 'subject' , 'grade', 'unit', 'enrollment_id', 'encoded_by', 'options', 'is_lab', 'is_nonacademic'
    ];

    public function enrollment()
    {
        return $this->belongsTo('App\Models\ScholarEnrollment', 'enrollment_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'encoded_by', 'id');
    }
}
