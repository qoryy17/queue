<?php

namespace App\Http\Requests\Configure;

use Illuminate\Foundation\Http\FormRequest;

class VoiceFormRequest extends FormRequest
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
            'apiKey' => 'required|string',
            'language' => 'required|string',
            'sound' => 'mimes:mp3,wav|max:10240|file',
        ];
    }

    public function messages(): array
    {
        return [
            'apiKey.required' => 'API Key is required',
            'apiKey.string' => 'API Key must be a string',
            'language.required' => 'Language is required',
            'language.string' => 'Language must be a string',
            'sound.mimes' => 'Sound file must be a MP3 or WAV format',
            'sound.max' => 'Sound file size should not exceed 10MB',
            'sound.file' => 'Sound file must be a file',
        ];
    }
}
