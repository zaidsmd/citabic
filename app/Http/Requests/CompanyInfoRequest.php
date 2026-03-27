<?php

namespace App\Http\Requests;

use App\Enums\CompanyInfoKey;
use Illuminate\Foundation\Http\FormRequest;

class CompanyInfoRequest extends FormRequest
{
    public function rules(): array
    {

        return [
            CompanyInfoKey::CREATION_DATE->value => 'required|date|date_format:m/d/Y',
            CompanyInfoKey::FULL_NAME->value => 'required|string|max:255',
            CompanyInfoKey::LEGAL_NAME->value => 'required|string|max:255',
            CompanyInfoKey::STATUS->value => 'required|string|max:255',
            CompanyInfoKey::LEGAL_FORM->value => 'required|string|max:255',
            CompanyInfoKey::CAPITAL->value => 'required|decimal:0,2|max_digits:20',
            CompanyInfoKey::ADDRESS->value => 'required|string|max:1000',
            CompanyInfoKey::PHONE->value => 'required|string|max:255',
            CompanyInfoKey::EMAIL->value => 'required|email|max:255',
            CompanyInfoKey::RC->value => 'required|string|max:255',
            CompanyInfoKey::ICE->value => 'required|string|max:255',
            CompanyInfoKey::LINKEDIN->value => 'nullable|url|max:255',
            CompanyInfoKey::INSTAGRAM->value => 'nullable|url|max:255',
            CompanyInfoKey::FACEBOOK->value => 'nullable|url|max:255',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
