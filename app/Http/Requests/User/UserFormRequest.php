<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
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
            'email' => 'required|string|email|max:255',
            'password' => 'nullable|string|min:8',
            'officer' => 'required|integer|exists:officers,id',
            'role' => 'required|string|in:Administrator,Officer',
            'block' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email is required',
            'email.string' => 'Email must be a string',
            'email.email' => 'Email must be a valid email address',
            'email.max' => 'Email must not exceed 255 characters',
            'password.string' => 'Password must be a string',
            'password.min' => 'Password must be at least 8 characters',
            'officer.required' => 'Officer is required',
            'officer.exists' => 'Officer does not exist',
            'officer.integer' => 'Officer must be an integer',
            'role.required' => 'Role is required',
            'role.string' => 'Role must be a string',
            'role.in' => 'Role must be either Administrator or Officer',
            'block.required' => 'Block is required'
        ];
    }
}
