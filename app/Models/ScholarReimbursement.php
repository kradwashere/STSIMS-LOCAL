<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScholarReimbursement extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount', 'attachment', 'scholar_id', 'checked_by', 'school_semester_id', 'benefit_id', 'is_reimbursed', 'is_approved'
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
}
