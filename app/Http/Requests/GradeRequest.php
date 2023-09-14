<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GradeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'lists' => 'sometimes|required|min:1',
            'files.*' => 'sometimes|required|mimes:pdf,docx|max:2000'
        ];
    }
}
