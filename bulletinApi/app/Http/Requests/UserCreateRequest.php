<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserCreateRequest extends FormRequest
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
        $rule = [
            'name' => 'required',
            'email' => 'required|email:filter|unique:users,email',
            'pass' => 'required|regex:"^(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{9,}$"',
            'cpass' => 'required|same:pass',
            'type' => 'required',
            'phone' => 'digits_between:0,20',
            'profile' => 'required|mimes:jpg,jpeg',
            'address' => 'max:255',
        ];

        if (request('dob')) {
            $rule['dob'] = 'date_format:Y-m-d';
        }
        return $rule;
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
     * Get the validation messages that apply to the request.
     *
     * @return bool
     */
    public function messages()
    {
        return [
            'name.required' => 'Name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'User with email already exist.',
            'pass.required' => 'Password is required.',
            'pass.regex' => 'Password must be 8 characters long, must contain at least one uppercase letter, one number.',
            'cpass.required' => 'Confirm password is required.',
            'cpass.same' => 'Password does not match.',
            'type.required' => 'Type is required.',
            'phone.digits_between' => 'Phone must not be more than 20 digits.',
            'dob.date_format' => 'Date of birth must be yyyy-mm-dd format.',
            'address.max' => 'Address must not be more than 255 characters.',
            'profile' => 'Profile is required.',
            'profile.mimes' => 'Profile image type is not supported.'
        ];
    }
}
