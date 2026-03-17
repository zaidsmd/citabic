<?php

namespace App\Http\Requests;



use Illuminate\Foundation\Http\FormRequest;

class UpdateOurApproachRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $locales = ['fr', 'en'];
        $rules   = [];

        // ── Section meta ──────────────────────────────────────────
        foreach ($locales as $locale) {
            $rules["section.translations.{$locale}.title"]           = ['required', 'string', 'max:255'];
        }

        // ── Items ─────────────────────────────────────────────────
        $rules['items']                    = ['required', 'array', 'min:1'];
        $rules['items.*.id']               = ['nullable', 'integer'];
        $rules['items.*.icon']             = ['required', 'string', 'regex:/^[a-z0-9-]+$/', 'max:80'];
        $rules['items.*.color_theme']      = ['required', 'string', 'in:blue,teal,amber,coral,indigo'];
        $rules['items.*.translations']     = ['required', 'array'];

        foreach ($locales as $locale) {
            $rules["items.*.translations.{$locale}.label"]       = ['required', 'string', 'max:100'];
            $rules["items.*.translations.{$locale}.title"]       = ['required', 'string', 'max:255'];
            $rules["items.*.translations.{$locale}.description"] = ['required', 'string', 'max:1000'];
        }

        return $rules;
    }

    /**
     * Normalise the 'visible' checkbox — unchecked sends nothing,
     * so we cast it to bool before validation.
     */
    protected function prepareForValidation(): void
    {
        $items = collect($this->input('items', []))->map(function ($item) {
            $item['visible'] = isset($item['visible']) && $item['visible'] == '1';
            return $item;
        })->all();

        $this->merge(['items' => $items]);
    }
}
