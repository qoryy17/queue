<?php

namespace App\Http\Requests\Configure;

use Illuminate\Foundation\Http\FormRequest;

class SettingFormRequest extends FormRequest
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
            'institution' => 'required|string|max:255',
            'eselon' => 'required|string|max:255',
            'jurisdiction' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postCode' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'website' => 'required|url|max:255',
            'contact' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'institution.required' => 'Institution is required',
            'institution.max' => 'Institution cannot exceed 255 characters',
            'eselon.required' => 'Eselon is required',
            'eselon.max' => 'Eselon cannot exceed 255 characters',
            'jurisdiction.required' => 'Jurisdiction is required',
            'jurisdiction.max' => 'Jurisdiction cannot exceed 255 characters',
            'unit.required' => 'Unit is required',
            'unit.max' => 'Unit cannot exceed 255 characters',
            'address.required' => 'Address is required',
            'address.max' => 'Address cannot exceed 255 characters',
            'province.required' => 'Province is required',
            'province.max' => 'Province cannot exceed 255 characters',
            'postCode.required' => 'Post code cannot exceed 255 characters',
            'postCode.max' => 'Post code cannot exceed 255 characters',
            'email.required' => 'Email is required',
            'email.email' => 'Email is not valid',
            'email.max' => 'Email cannot exceed 255 characters',
            'website.required' => 'Website is required',
            'website.url' => 'Website is not a valid URL',
            'website.max' => 'Website cannot exceed 255 characters',
            'contact.required' => 'Contact person is required',
            'contact.max' => 'Contact person cannot exceed 255 characters',
            'logo.image' => 'Logo must be an image file',
            'logo.mimes' => 'Logo must be a JPEG, PNG, or JPG file',
            'logo.max' => 'Logo file size cannot exceed 5MB',
        ];
    }
}
