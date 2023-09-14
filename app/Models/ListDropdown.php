<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListDropdown extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function expenses()
    {
        return $this->hasMany('App\Models\ListExpense', 'expenditure_id');
    } 

    public function awardees()
    {
        return $this->hasMany('App\Models\ScholarEducation', 'award_id');
    } 

    public function posts()
    {
        return $this->hasMany('App\Models\Post', 'type_id');
    } 

    public function getNameAttribute($value){
        if($this->classification == "Category"){
            return strtoupper($value);
        }else{
            return ucwords($value);
        }
    }
}
