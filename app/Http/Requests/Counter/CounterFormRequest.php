<?php

namespace App\Http\Requests\Counter;

use Illuminate\Foundation\Http\FormRequest;

class CounterFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255|nullable',
            'status' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Counter Code is required',
            'code.string' => 'Counter Code must be a string',
            'code.max' => 'Counter Code cannot be longer than 255 characters',
            'name.required' => 'Counter Name is required',
            'name.string' => 'Counter Name must be a string',
            'name.max' => 'Counter Name cannot be longer than 255 characters',
            'description.required' => 'Description is required',
            'description.string' => 'Description must be a string',
            'description.max' => 'Description cannot be longer than 255 characters',
            'status.required' => 'Status is required',
            'status.string' => 'Status must be a string',
            'status.max' => 'Status cannot be longer than 255 characters',
        ];
    }
}
