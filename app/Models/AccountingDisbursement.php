<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingDisbursement extends Model
{
    use HasFactory;

    protected $fillable = ['expense_id','report_id','amount','remarks','added_by','is_editable'];

    public function expense()
    {
        return $this->belongsTo('App\Models\ListExpense', 'expense_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'added_by', 'id');
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function setAmountAttribute($value)
    {   $val = trim($value,'₱ ');
        $val2 = str_replace(',','',$val);
        $this->attributes['amount'] = $val2;
    }
}
