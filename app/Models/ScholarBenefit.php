<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScholarBenefit extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'month', 'benefit_id', 'scholar_id', 'amount', 'release_type', 'status_id', 'release_id', 'school_semester_id', 'attachment', 'is_reimbursed'
    ];

    public function semester()
    {
        return $this->belongsTo('App\Models\SchoolSemester', 'school_semester_id', 'id');
    }

    
    public function scholar()
    {
        return $this->belongsTo('App\Models\Scholar', 'scholar_id', 'id');
    }

    public function benefit()
    {
        return $this->belongsTo('App\Models\ListPrivilege', 'benefit_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\ListStatus', 'status_id', 'id');
    }

    public function getMonthAttribute($value)
    {
        return date('M Y', strtotime($value));
    }
}
