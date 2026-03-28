<?php

namespace App\Services;

use App\Enums\ContentKey;
use App\Enums\Section;
use App\Models\SectionContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Provides domain logic for Section Content Page Service.
 */
class SectionContentPageService
{
    /**
     * Retrieve get index data for downstream processing.
     */
    public function getIndexData(): array
    {
        $locales = ['fr', 'en'];
        $textFieldSections = $this->textFieldSections();
        $translatableKeys = array_keys($textFieldSections);
        $imageFieldSections = $this->imageFieldSections();
        $imageDropzoneKeys = $this->imageDropzoneKeys();

        $contents = SectionContent::query()
            ->where(function ($query) use ($textFieldSections, $imageFieldSections) {
                foreach ($textFieldSections as $key => $section) {
                    $query->orWhere(function ($subQuery) use ($key, $section) {
                        $subQuery->where('key', $key)
                            ->where('section', $section);
                    });
                }

                foreach ($imageFieldSections as $key => $section) {
                    $query->orWhere(function ($subQuery) use ($key, $section) {
                        $subQuery->where('key', $key)
                            ->where('section', $section);
                    });
                }

                $query->orWhere(function ($subQuery) {
                    $subQuery->where('key', ContentKey::WHY_FEATURES->value)
                        ->where('section', Section::WHY_CHOOSE_US->value);
                });

                $query->orWhere(function ($subQuery) {
                    $subQuery->where('key', ContentKey::HERO_VIDEO->value)
                        ->where('section', Section::HERO->value);
                });
            })
            ->get();

        $formValues = [];
        foreach ($locales as $locale) {
            foreach ($translatableKeys as $key) {
                $formValues[$locale][$key] = '';
            }
        }

        $localizedEntries = $contents
            ->whereIn('key', $translatableKeys)
            ->whereIn('language', $locales);

        foreach ($localizedEntries as $entry) {
            $formValues[$entry->language][$entry->key] = $entry->value ?? '';
        }

        $whyFeatures = [];
        foreach ($locales as $locale) {
            $rawFeatures = $contents
                ->where('key', ContentKey::WHY_FEATURES->value)
                ->where('language', $locale)
                ->first()?->value;

            $decoded = json_decode($rawFeatures ?? '[]', true);
            $whyFeatures[$locale] = is_array($decoded) ? $decoded : [];
        }

        $savedWhyFeatures = [];
        foreach ($locales as $locale) {
            $savedFeatures = old('why_features.'.$locale, $whyFeatures[$locale] ?? []);
            $savedWhyFeatures[$locale] = is_array($savedFeatures) ? $savedFeatures : [];
        }

        $media = [];
        foreach ($imageDropzoneKeys as $key) {
            $path = $contents
                ->where('key', $key)
                ->where('language', 'fr')
                ->first()?->value;

            $media[$key] = [
                'path' => $path,
                'url' => $path ? Storage::disk('public')->url($path) : null,
            ];
        }

        $heroVideoPath = $contents
            ->where('key', ContentKey::HERO_VIDEO->value)
            ->where('language', 'fr')
            ->first()?->value;

        $heroVideo = [
            'path' => $heroVideoPath,
            'url' => $heroVideoPath ? Storage::disk('public')->url($heroVideoPath) : null,
        ];

        $contentSections = $this->buildContentSections($formValues, $locales);
        $tinyMceSelector = $this->buildTinyMceSelector($contentSections, $locales);
        $mediaSections = [
            [
                'title' => __('admin.section.'.Section::ABOUT->value).' - Images',
                'icon' => 'fa fa-images',
                'cards' => [
                    [
                        'columnClass' => 'col-md-6',
                        'contentKey' => ContentKey::ABOUT_IMAGE_1->value,
                        'label' => __('admin.section.contents.labels.'.ContentKey::ABOUT_IMAGE_1->value),
                        'size' => '(410x419)',
                        'path' => $media[ContentKey::ABOUT_IMAGE_1->value]['path'] ?? null,
                        'url' => $media[ContentKey::ABOUT_IMAGE_1->value]['url'] ?? null,
                        'maxHeightClass' => 'media-preview-tall',
                    ],
                    [
                        'columnClass' => 'col-md-3',
                        'contentKey' => ContentKey::ABOUT_IMAGE_2->value,
                        'label' => __('admin.section.contents.labels.'.ContentKey::ABOUT_IMAGE_2->value),
                        'size' => '(193x185)',
                        'path' => $media[ContentKey::ABOUT_IMAGE_2->value]['path'] ?? null,
                        'url' => $media[ContentKey::ABOUT_IMAGE_2->value]['url'] ?? null,
                        'maxHeightClass' => 'media-preview-compact',
                    ],
                    [
                        'columnClass' => 'col-md-3',
                        'contentKey' => ContentKey::ABOUT_IMAGE_3->value,
                        'label' => __('admin.section.contents.labels.'.ContentKey::ABOUT_IMAGE_3->value),
                        'size' => '(193x185)',
                        'path' => $media[ContentKey::ABOUT_IMAGE_3->value]['path'] ?? null,
                        'url' => $media[ContentKey::ABOUT_IMAGE_3->value]['url'] ?? null,
                        'maxHeightClass' => 'media-preview-compact',
                    ],
                ],
            ],
            [
                'title' => __('admin.section.contents.labels.'.ContentKey::WHY_IMAGE->value),
                'icon' => 'fa fa-star',
                'cards' => [
                    [
                        'columnClass' => 'col-md-6',
                        'contentKey' => ContentKey::WHY_IMAGE->value,
                        'label' => __('admin.section.contents.labels.'.ContentKey::WHY_IMAGE->value),
                        'path' => $media[ContentKey::WHY_IMAGE->value]['path'] ?? null,
                        'url' => $media[ContentKey::WHY_IMAGE->value]['url'] ?? null,
                    ],
                ],
            ],
            [
                'title' => __('admin.section.footer').' - '.__('admin.section.contents.labels.'.ContentKey::SECTION_IMAGE->value),
                'icon' => 'fa fa-image',
                'cards' => [
                    [
                        'columnClass' => 'col-md-6',
                        'contentKey' => ContentKey::SECTION_IMAGE->value,
                        'label' => __('admin.section.contents.labels.'.ContentKey::SECTION_IMAGE->value),
                        'path' => $media[ContentKey::SECTION_IMAGE->value]['path'] ?? null,
                        'url' => $media[ContentKey::SECTION_IMAGE->value]['url'] ?? null,
                    ],
                ],
            ],
        ];

        $sectionContentConfig = [
            'csrfToken' => csrf_token(),
            'uploadImageUrl' => route('admin.sections.upload-image'),
            'uploadVideoUrl' => route('admin.sections.upload-video'),
            'imageKeys' => $imageDropzoneKeys,
            'tinyMceSelector' => $tinyMceSelector,
            'i18n' => [
                'whyFeatureTitleLabel' => __('admin.section.contents.labels.why_feature_title'),
                'whyFeatureTitlePlaceholder' => __('admin.section.placeholders.why_feature_title'),
                'whyFeatureTextLabel' => __('admin.section.contents.labels.why_feature_text'),
                'whyFeatureTextPlaceholder' => __('admin.section.placeholders.why_feature_text'),
            ],
        ];

        return [
            'formValues' => $formValues,
            'locales' => $locales,
            'whyFeatures' => $whyFeatures,
            'savedWhyFeatures' => $savedWhyFeatures,
            'media' => $media,
            'mediaSections' => $mediaSections,
            'heroVideo' => $heroVideo,
            'heroVideoField' => ContentKey::HERO_VIDEO->value,
            'contentSections' => $contentSections,
            'imageDropzoneKeys' => $imageDropzoneKeys,
            'sectionContentConfig' => $sectionContentConfig,
        ];
    }

    /**
     * Persist updates to the resource.

     *

     * @param  Request  $request  Parameter.
     */
    public function update(Request $request): void
    {
        $locales = ['en', 'fr'];
        $textFields = $this->textFieldSections();

        foreach ($textFields as $key => $section) {
            foreach ($locales as $locale) {
                $value = $request->input($key.'.'.$locale);
                if ($value === null) {
                    continue;
                }
                SectionContent::updateOrCreate(
                    ['section' => $section, 'key' => $key, 'language' => $locale],
                    ['value' => $value]
                );
            }
        }

        $imageFields = $this->imageFieldSections();
        foreach ($imageFields as $key => $section) {
            $path = $request->input($key);
            if ($path) {
                SectionContent::updateOrCreate(
                    ['section' => $section, 'key' => $key, 'language' => 'fr'],
                    ['value' => $path]
                );
            }
        }

        foreach ($locales as $locale) {
            $features = $request->input('why_features.'.$locale, []);
            if (is_array($features)) {
                $filtered = array_values(array_filter($features, fn ($feature) => ! empty($feature['title']) || ! empty($feature['text'])));
                SectionContent::updateOrCreate(
                    ['section' => Section::WHY_CHOOSE_US->value, 'key' => ContentKey::WHY_FEATURES->value, 'language' => $locale],
                    ['value' => json_encode($filtered, JSON_UNESCAPED_UNICODE)]
                );
            }
        }

        $heroVideoPath = $request->input(ContentKey::HERO_VIDEO->value);
        if ($heroVideoPath) {
            SectionContent::updateOrCreate(
                ['section' => Section::HERO->value, 'key' => ContentKey::HERO_VIDEO->value, 'language' => 'fr'],
                ['value' => $heroVideoPath]
            );
        }
    }

    protected function translatableKeys(): array
    {
        return array_keys($this->textFieldSections());
    }

    protected function textFieldSections(): array
    {
        return [
            ContentKey::HERO_TITLE->value => Section::HERO->value,
            ContentKey::HERO_SUBTITLE->value => Section::HERO->value,
            ContentKey::ABOUT_TITLE->value => Section::ABOUT->value,
            ContentKey::ABOUT_SUBTITLE->value => Section::ABOUT->value,
            ContentKey::ABOUT_TEXT->value => Section::ABOUT->value,
            ContentKey::DOMAIN_TITLE->value => Section::DOMAIN->value,
            ContentKey::DOMAIN_SUBTITLE->value => Section::DOMAIN->value,
            ContentKey::DOMAIN_TEXT->value => Section::DOMAIN->value,
            ContentKey::PROJECTS_SUBTITLE->value => Section::PROJECTS->value,
            ContentKey::PROJECTS_TITLE->value => Section::PROJECTS->value,
            ContentKey::PROJECTS_TEXT->value => Section::PROJECTS->value,
            ContentKey::WHY_SUBTITLE->value => Section::WHY_CHOOSE_US->value,
            ContentKey::WHY_TITLE->value => Section::WHY_CHOOSE_US->value,
            ContentKey::WHY_TEXT->value => Section::WHY_CHOOSE_US->value,
            ContentKey::BLOG_SUBTITLE->value => Section::HOME->value,
            ContentKey::BLOG_TITLE->value => Section::HOME->value,
            ContentKey::BLOG_TEXT->value => Section::HOME->value,
            ContentKey::VALUES_SUBTITLE->value => Section::HOME->value,
            ContentKey::VALUES_TITLE->value => Section::HOME->value,
            ContentKey::VALUES_TEXT->value => Section::HOME->value,
        ];
    }

    protected function imageDropzoneKeys(): array
    {
        return array_keys($this->imageFieldSections());
    }

    protected function imageFieldSections(): array
    {
        return [
            ContentKey::ABOUT_IMAGE_1->value => Section::ABOUT->value,
            ContentKey::ABOUT_IMAGE_2->value => Section::ABOUT->value,
            ContentKey::ABOUT_IMAGE_3->value => Section::ABOUT->value,
            ContentKey::WHY_IMAGE->value => Section::WHY_CHOOSE_US->value,
            ContentKey::SECTION_IMAGE->value => Section::FOOTER->value,
        ];
    }

    protected function buildContentSections(array $formValues, array $locales): array
    {
        $sections = [
            [
                'title' => __('admin.section.'.Section::HERO->value),
                'icon' => 'fa fa-home',
                'hasWhyFeatures' => false,
                'fields' => [
                    ['key' => ContentKey::HERO_TITLE->value, 'component' => 'text-input', 'columnClass' => 'col-md-6', 'required' => true],
                    ['key' => ContentKey::HERO_SUBTITLE->value, 'component' => 'text-input', 'columnClass' => 'col-md-6', 'required' => true],
                ],
            ],
            [
                'title' => __('admin.section.'.Section::ABOUT->value),
                'icon' => 'fa fa-building',
                'hasWhyFeatures' => false,
                'fields' => [
                    ['key' => ContentKey::ABOUT_TITLE->value, 'component' => 'text-input', 'columnClass' => 'col-md-6', 'required' => true],
                    ['key' => ContentKey::ABOUT_SUBTITLE->value, 'component' => 'text-input', 'columnClass' => 'col-md-6', 'required' => true],
                    ['key' => ContentKey::ABOUT_TEXT->value, 'component' => 'textarea', 'columnClass' => 'col-md-12', 'required' => true, 'rows' => 2, 'isTinyMce' => true],
                ],
            ],
            [
                'title' => __('admin.section.'.Section::DOMAIN->value),
                'icon' => 'fa fa-globe',
                'hasWhyFeatures' => false,
                'fields' => [
                    ['key' => ContentKey::DOMAIN_TITLE->value, 'component' => 'text-input', 'columnClass' => 'col-md-6', 'required' => true],
                    ['key' => ContentKey::DOMAIN_SUBTITLE->value, 'component' => 'text-input', 'columnClass' => 'col-md-6', 'required' => true],
                    ['key' => ContentKey::DOMAIN_TEXT->value, 'component' => 'textarea', 'columnClass' => 'col-md-12', 'required' => true, 'rows' => 2, 'isTinyMce' => true],
                ],
            ],
            [
                'title' => __('admin.section.'.Section::PROJECTS->value),
                'icon' => 'fa fa-project-diagram',
                'hasWhyFeatures' => false,
                'fields' => [
                    ['key' => ContentKey::PROJECTS_SUBTITLE->value, 'component' => 'text-input', 'columnClass' => 'col-md-4', 'required' => true],
                    ['key' => ContentKey::PROJECTS_TITLE->value, 'component' => 'text-input', 'columnClass' => 'col-md-8', 'required' => true],
                    ['key' => ContentKey::PROJECTS_TEXT->value, 'component' => 'textarea', 'columnClass' => 'col-md-12', 'required' => true, 'rows' => 2, 'isTinyMce' => true],
                ],
            ],
            [
                'title' => __('admin.section.'.Section::WHY_CHOOSE_US->value),
                'icon' => 'fa fa-star',
                'hasWhyFeatures' => true,
                'fields' => [
                    ['key' => ContentKey::WHY_SUBTITLE->value, 'component' => 'text-input', 'columnClass' => 'col-md-4', 'required' => false],
                    ['key' => ContentKey::WHY_TITLE->value, 'component' => 'text-input', 'columnClass' => 'col-md-8', 'required' => false],
                    ['key' => ContentKey::WHY_TEXT->value, 'component' => 'textarea', 'columnClass' => 'col-md-12', 'required' => false, 'rows' => 2],
                ],
            ],
            [
                'title' => __('admin.section.contents.labels.blog_section'),
                'icon' => 'fa fa-blog',
                'hasWhyFeatures' => false,
                'fields' => [
                    ['key' => ContentKey::BLOG_SUBTITLE->value, 'component' => 'text-input', 'columnClass' => 'col-md-4', 'required' => false],
                    ['key' => ContentKey::BLOG_TITLE->value, 'component' => 'text-input', 'columnClass' => 'col-md-8', 'required' => false],
                    ['key' => ContentKey::BLOG_TEXT->value, 'component' => 'textarea', 'columnClass' => 'col-md-12', 'required' => false, 'rows' => 2, 'isTinyMce' => true],
                ],
            ],
            [
                'title' => __('admin.section.contents.labels.values_section'),
                'icon' => 'fa fa-gem',
                'hasWhyFeatures' => false,
                'fields' => [
                    ['key' => ContentKey::VALUES_SUBTITLE->value, 'component' => 'text-input', 'columnClass' => 'col-md-4', 'required' => false],
                    ['key' => ContentKey::VALUES_TITLE->value, 'component' => 'text-input', 'columnClass' => 'col-md-8', 'required' => false],
                    ['key' => ContentKey::VALUES_TEXT->value, 'component' => 'textarea', 'columnClass' => 'col-md-12', 'required' => false, 'rows' => 2, 'isTinyMce' => true],
                ],
            ],
        ];

        return array_map(function (array $section) use ($formValues, $locales): array {
            $fieldsByLocale = [];

            foreach ($locales as $locale) {
                $fieldsByLocale[$locale] = array_map(function (array $field) use ($formValues, $locale): array {
                    $key = $field['key'];
                    $name = "{$key}[{$locale}]";

                    return [
                        'key' => $key,
                        'name' => $name,
                        'component' => $field['component'],
                        'columnClass' => $field['columnClass'],
                        'required' => $locale !== 'en' && $field['required'],
                        'rows' => $field['rows'] ?? 2,
                        'placeholder' => __('admin.section.placeholders.'.$key),
                        'label' => __('admin.section.contents.labels.'.$key),
                        'value' => $formValues[$locale][$key] ?? '',
                        'errorKey' => "{$key}.{$locale}",
                        'id' => "textarea-{$key}-{$locale}",
                        'isTinyMce' => $field['isTinyMce'] ?? false,
                    ];
                }, $section['fields']);
            }

            return [
                'title' => $section['title'],
                'icon' => $section['icon'],
                'hasWhyFeatures' => $section['hasWhyFeatures'],
                'fields' => $fieldsByLocale,
            ];
        }, $sections);
    }

    protected function buildTinyMceSelector(array $sections, array $locales): string
    {
        $selectors = [];

        foreach ($sections as $section) {
            foreach ($locales as $locale) {
                foreach ($section['fields'][$locale] ?? [] as $field) {
                    if (($field['component'] ?? null) === 'textarea' && ($field['isTinyMce'] ?? false)) {
                        $selectors[] = '#'.$field['id'];
                    }
                }
            }
        }

        return implode(', ', array_values(array_unique($selectors)));
    }
}
