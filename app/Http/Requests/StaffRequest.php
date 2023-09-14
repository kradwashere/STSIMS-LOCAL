<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => 'sometimes|required|max:20|unique:users,username,'.$this->id,
            'email' => 'sometimes|required|email|max:150|unique:users,email,'.$this->id,
            'firstname' => 'sometimes|required|string|max:100',
            'lastname' => 'sometimes|required|string|max:100',
            'middlename' => 'sometimes|required|string|max:20',
            'suffix' => 'sometimes|nullable|string|max:20',
            'gender' => 'sometimes|required',
            'province' => 'sometimes|required_if:role,PSTO Staff',
            'school' => 'sometimes|required_if:role,University Coordinator',
            'mobile' => 'sometimes|required|numeric|unique:user_profiles,mobile,'.$this->profile_id,
            'img' => 'sometimes|nullable|image64:jpeg,jpg,png',
            'role' => 'sometimes|required',
        ];
    }
}
