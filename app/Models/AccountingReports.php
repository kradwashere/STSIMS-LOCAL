<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingReports extends Model
{
    use HasFactory;

    public function balances()
    {
        return $this->hasMany('App\Models\AccountingBalance', 'report_id');
    } 
}
