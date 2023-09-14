<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReimbursementRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'school_semester_id' => 'sometimes|required',
            'benefit_id' => 'sometimes|required',
            'scholar_id' => 'sometimes|required',
            'amount' => 'sometimes|required',
            'remarks' => 'sometimes|required',
            'files.*' => 'required|mimes:pdf|max:2000'
        ];
    }
}
