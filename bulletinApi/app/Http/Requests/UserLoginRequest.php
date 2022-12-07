<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserLoginRequest extends FormRequest
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
     * Errors reponse when validation failed
     * @param Illuminate\Contracts\Validation\Validator $validator
     * @return void
     */
    public function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation errors',
            'error' => $validator->errors()
        ],400));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|email:filter',
            'password' => 'required'
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return bool
     */
    public function messages()
    {
        return [
            'email.required' => 'Email is required.',
            'email.email' => 'The email must be a valid email address',
            'password.required' => 'Password is required.'
        ];
    }
}
