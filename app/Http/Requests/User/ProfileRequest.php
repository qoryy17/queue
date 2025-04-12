<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'nip' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'photo' => 'nullable|file|mimes:png,jpg|max:5120|image',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email is required',
            'email.string' => 'Email must be a string',
            'email.email' => 'Email must be a valid email address',
            'email.max' => 'Email must not exceed 255 characters',
            'nip.string' => 'NIP must be a string',
            'nip.max' => 'NIP must not exceed 255 characters',
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'name.max' => 'Name must not exceed 255 characters',
            'photo.file' => 'Photo must be a file',
            'photo.mimes' => 'Photo must be a PNG or JPG file',
            'photo.max' => 'Photo must not exceed 5MB',
            'photo.image' => 'Photo must be an image',
        ];
    }
}
