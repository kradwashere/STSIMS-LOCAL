<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListAgency extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'code', 'acronym', 'website', 'avatar', 'status'
    ];

    public function region()
    {
        return $this->belongsTo('App\Models\LocationRegion', 'region_code', 'code');
    }

    public function user(): MorphOne
    {
        return $this->morphOne(UserProfile::class, 'userable');
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
