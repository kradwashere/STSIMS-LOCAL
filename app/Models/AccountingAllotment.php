<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingAllotment extends Model
{
    use HasFactory;

    protected $fillable = ['code','report_id','check_no','checked_at','credited_at','remarks','added_by','is_editable'];

    public function total()
    {
        return $this->hasMany('App\Models\AccountingAllotmentList', 'allotment_id')->sum('amount');
    } 

    public function lists()
    {
        return $this->hasMany('App\Models\AccountingAllotmentList', 'allotment_id');
    } 

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'added_by', 'id');
    }

    public function getCheckedAtAttribute($value)
    {
        return date('M d, Y', strtotime($value));
    }

    public function getCreditedAtAttribute($value)
    {
        return date('M d, Y', strtotime($value));
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
