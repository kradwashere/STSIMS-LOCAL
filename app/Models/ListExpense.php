<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListExpense extends Model
{
    use HasFactory;

    protected $fillable = ['name','code','expenditure_id'];

    public function expenditure()
    {
        return $this->belongsTo('App\Models\ListDropdown', 'expenditure_id', 'id');
    }

    public function allotments()
    {
        return $this->hasMany('App\Models\AccountingAllotmentList', 'expense_id');
    } 

    public function disbursements()
    {
        return $this->hasMany('App\Models\AccountingDisbursement', 'expense_id');
    } 

    public function add()
    {
        return $this->hasMany('App\Models\AccountingRealignment', 'receiver_class');
    } 

    public function minus()
    {
        return $this->hasMany('App\Models\AccountingRealignment', 'sender_class');
    } 

    public function balances()
    {
        return $this->hasMany('App\Models\AccountingBalance', 'expense_id');
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
