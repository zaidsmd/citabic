<?php

namespace App\Services;

use App\Models\AppSetting;
use Google\Cloud\Translate\V3\Client\TranslationServiceClient;
use Google\Cloud\Translate\V3\TranslateTextRequest;
use RuntimeException;
use Throwable;

class PostTranslationService
{
    public function translateFrToEn(?string $title, ?string $excerpt, array $blocks): array
    {
        return [
            'title_en' => $this->translateText($title ?? '', false),
            'excerpt_en' => $this->translateText($excerpt ?? '', false),
            'blocks' => $this->translateBlocks($blocks),
        ];
    }

    private function translateBlocks(array $blocks): array
    {
        return collect($blocks)->map(function (mixed $block): mixed {
            if (! is_array($block)) {
                return $block;
            }

            $translated = $block;
            $type = (string) ($block['type'] ?? '');

            if (in_array($type, ['heading', 'subheading', 'quote'], true)) {
                $translated['content_en'] = $this->translateText((string) ($block['content'] ?? ''), false);
            }

            if ($type === 'paragraph') {
                $translated['content_en'] = $this->translateText((string) ($block['content'] ?? ''), true);
            }

            if ($type === 'quote') {
                $translated['author_en'] = $this->translateText((string) ($block['author'] ?? ''), false);
            }

            if ($type === 'list') {
                $items = is_array($block['items'] ?? null) ? $block['items'] : [];
                $translated['items_en'] = collect($items)
                    ->map(fn (mixed $item): string => $this->translateText((string) $item, false))
                    ->values()
                    ->all();
            }

            return $translated;
        })->values()->all();
    }

    private function translateText(string $text, bool $isHtml): string
    {
        if (trim($text) === '') {
            return '';
        }

        try {
            $client = $this->client();
            $request = (new TranslateTextRequest)
                ->setParent($this->parentPath())
                ->setMimeType($isHtml ? 'text/html' : 'text/plain')
                ->setSourceLanguageCode('fr')
                ->setTargetLanguageCode('en')
                ->setContents([$text]);

            $response = $client->translateText($request);
            $translation = $response->getTranslations()[0] ?? null;

            return html_entity_decode((string) ($translation?->getTranslatedText() ?? ''), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        } catch (Throwable $exception) {
            throw new RuntimeException(__('admin.posts.translation_error'), previous: $exception);
        }
    }

    private function client(): TranslationServiceClient
    {
        $config = [];

        $projectId = $this->projectId();
        if (is_string($projectId) && $projectId !== '') {
            $config['projectId'] = $projectId;
        }

        $keyFilePath = $this->keyFilePath();
        if (is_string($keyFilePath) && $keyFilePath !== '') {
            $config['keyFilePath'] = $keyFilePath;
        }

        return new TranslationServiceClient($config);
    }

    private function parentPath(): string
    {
        $projectId = $this->projectId();

        if (! is_string($projectId) || trim($projectId) === '') {
            throw new RuntimeException(__('admin.posts.translation_error'));
        }

        return sprintf('projects/%s/locations/global', $projectId);
    }

    private function projectId(): ?string
    {
        $settingValue = AppSetting::getValue('google_translate_project_id');
        if (is_string($settingValue) && trim($settingValue) !== '') {
            return $settingValue;
        }

        return config('services.google_translate.project_id');
    }

    private function keyFilePath(): ?string
    {
        $settingPath = AppSetting::getValue('google_translate_key_file_path');
        if (is_string($settingPath) && trim($settingPath) !== '') {
            if (str_starts_with($settingPath, '/')) {
                return $settingPath;
            }

            return storage_path('app/'.$settingPath);
        }

        return config('services.google_translate.key_file_path');
    }
}
