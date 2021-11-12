<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */ 
    public function rules()
    {
        return [
            'username' => ['required','string'],
            'password' => ['required','string'],
        ];
    }
    public function messages()
    {
        return[
            'usernam.required' => 'name is required',
            'password.required' => 'pass is required',
        ];
    }
}
