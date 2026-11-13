<?php

namespace App\Http\Requests\Admin;

use App\Services\AboutUsService;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAboutUsRequest extends FormRequest
{
    protected AboutUsService $aboutUsService;

    public function __construct()
    {
        $this->aboutUsService = app(AboutUsService::class);
    }

    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return $this->aboutUsService->getValidationRules();
    }

    public function messages(): array
    {
        return $this->aboutUsService->getValidationMessages();
    }

    public function attributes(): array
    {
        $attributes = [];

        foreach ($this->aboutUsService->getContentFields() as $field) {
            $fieldValue = $field->value;
            $attributes[$fieldValue] = __('admin.pages.about.'.$fieldValue).' (FR)';
            $attributes["en.{$fieldValue}"] = __('admin.pages.about.'.$fieldValue).' (EN)';
            $attributes["ar.{$fieldValue}"] = __('admin.pages.about.'.$fieldValue).' (AR)';
        }

        return $attributes;
    }
}
