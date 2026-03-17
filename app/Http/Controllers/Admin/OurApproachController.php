<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ContentKey;
use App\Enums\Section;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOurApproachRequest;
use App\Models\ApproachItem;
use App\Models\ApproachItemTranslation;
use App\Models\SectionContent;
use Dflydev\DotAccessData\Data;

class OurApproachController extends Controller
{
    public function index()
    {
        $items = ApproachItem::query()
            ->with('translations')
            ->orderBy('order')
            ->get()
            ->map(function (ApproachItem $item): array {
                $translations = [
                    'fr' => ['label' => '', 'title' => '', 'description' => ''],
                    'en' => ['label' => '', 'title' => '', 'description' => ''],
                ];

                foreach ($item->translations as $translation) {
                    if (!isset($translations[$translation->locale])) {
                        continue;
                    }

                    $translations[$translation->locale] = [
                        'label' => $translation->label,
                        'title' => $translation->title,
                        'description' => $translation->description,
                    ];
                }

                return [
                    'id' => $item->id,
                    'color_theme' => $item->color,
                    'icon' => $item->icon,
                    'order' => $item->order,
                    'visible' => true,
                    'translations' => $translations,
                ];
            })
            ->values()
            ->all();

        $sectionMeta = [
            'translations' => [
                'fr' => ['title' => ''],
                'en' => ['title' => ''],
            ],
        ];

        SectionContent::query()
            ->where('section', Section::OUR_APPROACH->value)
            ->where('key', ContentKey::OUR_APPROACH_TITLE->value)
            ->whereIn('language', ['fr', 'en'])
            ->get()
            ->each(function (SectionContent $content) use (&$sectionMeta): void {
                $sectionMeta['translations'][$content->language]['title'] = $content->value;
            });

        return view('admin.our-approach.index', compact('items', 'sectionMeta'));
    }


    public function update(UpdateOurApproachRequest $request)
    {
        try {
            // Update section title for each language
            $this->updateSectionTitles($request);

            // Update approach items and their translations
            if ($request->filled('items')) {

                $this->updateApproachItems($request);

                // Delete items that are no longer present
                $this->deleteRemovedItems($request);
            }

            return redirect()->back()->with('success', 'Approach updated successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update approach. Please try again.')
                ->withInput();
        }
    }

    private function updateSectionTitles(UpdateOurApproachRequest $request): void
    {
        foreach (['en', 'fr'] as $language) {
            $titleKey = "section.translations.{$language}.title";
            if ($request->has($titleKey)) {
                SectionContent::updateOrCreate(
                    [
                        'section' => Section::OUR_APPROACH,
                        'language' => $language,
                        'key' => ContentKey::OUR_APPROACH_TITLE
                    ],
                    ['value' => $request->input($titleKey)]
                );
            }
        }
    }

    private function updateApproachItems(UpdateOurApproachRequest $request): void
    {
        $items = $request->input('items', []);
        $languages = ['en', 'fr'];

        foreach ($items as $itemData) {
            $approachItem = $this->updateOrCreateApproachItem($itemData);

            // Update translations for each language
            foreach ($languages as $language) {
                $this->updateApproachItemTranslation($approachItem, $language, $request);
            }
        }
    }

    private function updateOrCreateApproachItem(array $itemData): ApproachItem
    {
        $itemData = $this->prepareApproachItemData($itemData);

        if (!empty($itemData['id'])) {
            $approachItem = ApproachItem::findOrFail($itemData['id']);
            $approachItem->update($itemData);
            return $approachItem;
        }

        return ApproachItem::create($itemData);
    }

    private function prepareApproachItemData(array $itemData): array
    {
        return [
            'id' => $itemData['id'] ?? null,
            'color' => $itemData['color_theme'] ?? null,
            'icon' => (string)($itemData['icon'] ?? ''),
            'order' => $itemData['order'] ?? 0,
        ];
    }

    private function updateApproachItemTranslation(
        ApproachItem $approachItem,
        string $language,
        UpdateOurApproachRequest $request
    ): void {
        $translationKey = "section.translations.{$language}";

        if ($request->has($translationKey)) {
            $translationData = $request->input($translationKey);

            ApproachItemTranslation::updateOrCreate(
                [
                    'approach_item_id' => $approachItem->id,
                    'locale' => $language
                ],
                [
                    'title' => $translationData['title'] ?? null,
                    'description' => $translationData['description'] ?? null,
                    'label' => $translationData['label'] ?? null,
                ]
            );
        }
    }

    private function deleteRemovedItems(UpdateOurApproachRequest $request): void
    {
        $currentItemIds = collect($request->input('items', []))
            ->pluck('id')
            ->filter()
            ->toArray();

        if (!empty($currentItemIds)) {
            ApproachItem::whereNotIn('id', $currentItemIds)->delete();
        }
    }
}
