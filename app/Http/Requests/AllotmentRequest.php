<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AllotmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        switch($this->type){
            case 'disbursement': 
                $allowed = trim(str_replace(',','',$this->allowed),'₱ ');
                return [
                    'amount' => 'sometimes|required|greater:'.$allowed,
                    'expense_id' => 'sometimes|required',
                    'remarks' => 'sometimes|required'
                ];
            break;
            case 'allotment':
                return [
                    'check_no' => 'sometimes|required',
                    'checked_at' => 'sometimes|required',
                    'credited_at' => 'sometimes|required',
                    'remarks' => 'sometimes|required',
                ];
            break;
            case 'suballotment':
                return [
                    'amount' => 'sometimes|required',
                    'expense_id' => 'sometimes|required',
                    'remarks' => 'sometimes|required'
                ];
            break;
            case 'realignment':
                return [];
            break;
            case 'expense':
                return [];
            break;
        }
    }
}
