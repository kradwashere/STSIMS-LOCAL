<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingRealignment extends Model
{
    use HasFactory;

    protected $fillable = ['amount','receiver_class','sender_class','added_by','attachment','is_approved','is_paid'];

    public function sender()
    {
        return $this->belongsTo('App\Models\ListExpense', 'sender_class', 'id');
    }

    public function receiver()
    {
        return $this->belongsTo('App\Models\ListExpense', 'receiver_class', 'id');
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
