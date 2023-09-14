<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingBalance extends Model
{
    use HasFactory;

    protected $fillable = ['year','report_id','quarter','amount','expense_id'];

    public function expense()
    {
        return $this->belongsTo('App\Models\ListExpense', 'expense_id', 'id');
    }
}
