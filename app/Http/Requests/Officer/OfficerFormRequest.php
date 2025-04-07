<?php

namespace App\Http\Requests\Officer;

use Illuminate\Foundation\Http\FormRequest;

class OfficerFormRequest extends FormRequest
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
            'nip' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'counter' => 'nullable|string|max:255',
            'photo' => 'nullable|file|mimes:png,jpg|max:5120|image',
            'block' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'nip.string' => 'NIP must be string',
            'nip.max' => 'NIP cannot exceed 255 characters',
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'name.max' => 'Name cannot exceed 255 characters',
            'position.required' => 'Position is required',
            'position.string' => 'Position must be a string',
            'position.max' => 'Position cannot exceed 255 characters',
            'photo.nullable' => 'Photo is optional',
            'photo.file' => 'Photo must be a file',
            'photo.mimes' => 'Photo must be a PNG or JPG file',
            'photo.max' => 'Photo file size cannot exceed 5MB',
            'photo.image' => 'Photo must be an image',
            'counter.string' => 'Counter must be string',
            'counter.max' => 'Counter cannot exceed 255 characters',
            'block.required' => 'Block is required',
            'block.string' => 'Block must be a string',
            'block.max' => 'Block cannot exceed 255 characters',
        ];
    }
}
