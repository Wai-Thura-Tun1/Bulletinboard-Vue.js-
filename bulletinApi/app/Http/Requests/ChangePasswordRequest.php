<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ChangePasswordRequest extends FormRequest
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
        throw new HttpResponseException(
            response()->json([
                'message' => "Validation error",
                'error' => $validator->errors(),
            ],400)
        );
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'oldPass' => 'required',
            'newPass' => 'required|regex:"^(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{9,}$"|different:oldPass',
            'confirmPass' => 'required|same:newPass'
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
            'newPass.required' => 'New Password is required',
            'newPass.regex' => 'Password must be 8 characters long, must contain at least one uppercase letter, one number.',
            'newPass.different' => 'Old Password and New password must not be the same.',
            'oldPass.required' => 'Old Password is required',
            'confirmPass.required' => 'Confirm Password is required',
            'confirmPass.same' => 'New password and Confirm password must be same.'
        ];
    }
}
