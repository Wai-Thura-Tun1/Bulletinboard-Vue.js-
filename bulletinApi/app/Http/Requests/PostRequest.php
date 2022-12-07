<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PostRequest extends FormRequest
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
            'title' => 'required|max:255|unique:posts,title,'.request('id').'',
            'description' => 'required',
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
            'title.required' => 'Title is required',
            'title.max' => 'The title cannot be longer than 255 words.',
            'title.unique' => 'Post already exists.',
            'description.required' => 'Description is required',
        ];
    }
}
