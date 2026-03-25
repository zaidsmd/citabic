<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGoogleTranslateSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id' => ['required', 'string', 'max:255'],
            'key_file' => ['nullable', 'file', 'max:5120', 'mimetypes:application/json,text/plain'],
            'remove_key_file' => ['nullable', 'boolean'],
        ];
    }
}
