<?php

namespace App\Services;

use App\Enums\ContentKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Provides domain logic for About Us Service.
 */
class AboutUsService
{
    /**
     * Retrieve get content fields for downstream processing.
     */
    public function getContentFields(): array
    {
        return $this->contentFields;
    }

    /**
     * Retrieve get image fields for downstream processing.
     */
    public function getImageFields(): array
    {
        return $this->imageFields;
    }

    /**
     * Retrieve get about data for downstream processing.
     */
    public function getAboutData(): array
    {
        $contents = $this->fetchContents();
        $data = $this->prepareContentData($contents);
        $images = $this->prepareImageData();
        $imageKeys = array_map(fn ($field) => $field->value, $this->imageFields);

        return [
            'data' => $data,
            'images' => $images,
            'contentFields' => $this->contentFields,
            'imageFields' => $this->imageFields,
            'locales' => $this->locales,
            'contentSections' => $this->buildContentSections($data),
            'imageSections' => $this->buildImageSections($images),
            'tinyMceSelectors' => $this->buildTinyMceSelectors(),
            'imageKeys' => $imageKeys,
        ];
    }

    protected function buildContentSections(array $data): array
    {
        $sectionsByLocale = [];

        foreach ($this->locales as $locale) {
            $sections = [];

            foreach ($this->contentSectionsConfig as $sectionConfig) {
                $fields = array_map(
                    fn (string $fieldKey) => $this->buildContentField($fieldKey, $locale, $data),
                    $sectionConfig['fields']
                );

                $textInputFields = array_values(array_filter(
                    $fields,
                    fn (array $field) => $field['component'] === 'text-input'
                ));

                $textareaFields = array_values(array_filter(
                    $fields,
                    fn (array $field) => $field['component'] === 'textarea'
                ));

                $singleInputInSection = count($textInputFields) === 1;
                $textareaColumnClass = count($textareaFields) === 2 ? 'col-6' : 'col-12';

                $textInputFields = array_map(function (array $field) use ($singleInputInSection): array {
                    $field['column_class'] = $singleInputInSection ? 'col-12' : 'col-lg-6';

                    return $field;
                }, $textInputFields);

                $textareaFields = array_map(function (array $field) use ($textareaColumnClass): array {
                    $field['column_class'] = $textareaColumnClass;

                    return $field;
                }, $textareaFields);

                $sections[] = [
                    'title' => __($sectionConfig['title_key']).' ('.strtoupper($locale).')',
                    'icon' => $sectionConfig['icon'],
                    'text_input_fields' => $textInputFields,
                    'textarea_fields' => $textareaFields,
                ];
            }

            $sectionsByLocale[$locale] = $sections;
        }

        return $sectionsByLocale;
    }

    protected function buildContentField(string $fieldKey, string $locale, array $data): array
    {
        $isTextarea = in_array($fieldKey, $this->richTextFields, true)
            || in_array($fieldKey, $this->plainTextareaFields, true);

        $label = __('admin.pages.about.'.$fieldKey);
        if ($fieldKey === ContentKey::WHY_US_CARDS->value) {
            $label .= ' '.__('admin.pages.about.why_us_cards_hint');
        }

        return [
            'key' => $fieldKey,
            'name' => $locale === 'fr' ? $fieldKey : "en[{$fieldKey}]",
            'label' => $label.' ('.strtoupper($locale).')',
            'value' => $locale === 'fr'
                ? ($data[$fieldKey] ?? '')
                : ($data['en'][$fieldKey] ?? ''),
            'required' => $locale === 'fr' && in_array($fieldKey, $this->requiredFields, true),
            'component' => $isTextarea ? 'textarea' : 'text-input',
            'rows' => $fieldKey === ContentKey::WHY_US_CARDS->value ? 13 : 6,
        ];
    }

    protected function buildImageSections(array $images): array
    {
        return array_map(function (array $sectionConfig) use ($images): array {
            $fields = array_map(function (string $fieldKey) use ($images): array {
                return [
                    'key' => $fieldKey,
                    'label' => __('admin.pages.about.'.$fieldKey),
                    'value' => $images[$fieldKey] ?? null,
                ];
            }, $sectionConfig['fields']);

            return [
                'title' => __($sectionConfig['title_key']),
                'icon' => $sectionConfig['icon'],
                'fields' => $fields,
            ];
        }, $this->imageSectionsConfig);
    }

    protected function buildTinyMceSelectors(): array
    {
        return [
            'textarea#about_text',
            'textarea[id^="en_about_text"]',
            'textarea#why_us_text',
            'textarea[id^="en_why_us_text"]',
            'textarea#mission_text',
            'textarea[id^="en_mission_text"]',
        ];
    }

    /**
     * Update about data.

     *

     * @param  Request  $request  Parameter.
     */
    public function updateAboutData(Request $request): void
    {
        DB::transaction(function () use ($request) {
            $this->updateTranslatableFields($request);
            $this->updateImageFields($request);
        });
    }

    /**
     * Validate update.

     *

     * @param  Request  $request  Parameter.
     */
    public function validateUpdate(Request $request): array
    {
        $rules = [];

        // Rules for translatable fields
        foreach ($this->contentFields as $field) {
            $fieldValue = $field->value;
            $rules[$fieldValue] = 'nullable|string|max:65535';
            $rules["en.{$fieldValue}"] = 'nullable|string|max:65535';
        }

        // Rules for image fields
        foreach ($this->imageFields as $field) {
            $fieldValue = $field->value;
            $rules[$fieldValue] = 'nullable|string|max:255';
        }

        return $request->validate($rules);
    }

    /**
     * Retrieve get validation rules for downstream processing.
     */
    public function getValidationRules(): array
    {
        $rules = [];

        // Rules for translatable fields with specific constraints
        foreach ($this->contentFields as $field) {
            $fieldValue = $field->value;
            $fieldRules = $this->getFieldValidationRules($field);

            $rules[$fieldValue] = $fieldRules;
            $rules["en.{$fieldValue}"] = $fieldRules;
        }

        // Rules for image fields
        foreach ($this->imageFields as $field) {
            $fieldValue = $field->value;
            $rules[$fieldValue] = 'nullable|string|max:255';
        }

        return $rules;
    }

    /**
     * Retrieve get validation messages for downstream processing.
     */
    public function getValidationMessages(): array
    {
        $messages = [];

        foreach ($this->contentFields as $field) {
            $fieldValue = $field->value;
            $label = __('admin.pages.about.'.$fieldValue);

            $messages["{$fieldValue}.required"] = __('validation.required', ['attribute' => $label]);
            $messages["{$fieldValue}.max"] = __('validation.max.string', ['attribute' => $label, 'max' => ':max']);

            $messages["en.{$fieldValue}.required"] = __('validation.required', ['attribute' => $label.' (EN)']);
            $messages["en.{$fieldValue}.max"] = __('validation.max.string', ['attribute' => $label.' (EN)', 'max' => ':max']);
        }

        return $messages;
    }
}
