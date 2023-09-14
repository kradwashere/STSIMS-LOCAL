<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'signatories',
        'information',
    ];

    public function agency()
    {
        return $this->belongsTo('App\Models\ListAgency', 'agency_id', 'id');
    }

}
