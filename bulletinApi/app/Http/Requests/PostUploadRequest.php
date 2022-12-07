<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PostUploadRequest extends FormRequest
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
            'data' => 'required|mimes:csv|max:2000'
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
            'data.required' => 'File is required',
            'data.mimes' => 'File type must be csv format',
            'data.max' => 'File size must be greater than 2MB.'
        ];
    }
}
