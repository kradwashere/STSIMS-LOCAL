<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolGrading extends Model
{
    use HasFactory;

    protected $fillable = [
        'grade',
        'upper_limit',
        'lower_limit',
        'school_id',
        'is_active',
        'is_failed',
        'is_incomplete'
    ];
}
