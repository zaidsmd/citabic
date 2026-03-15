<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\CitabicProfile;
use App\Models\CitabicReference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CitabicController extends Controller
{
    public function home(): View
    {
        return view('guest.pages.home', $this->sharedData());
    }

    public function company(): View
    {
        return view('guest.pages.company', $this->sharedData());
    }

    public function expertise(): View
    {
        return view('guest.pages.expertise', $this->sharedData());
    }

    public function references(): View
    {
        return view('guest.pages.references', $this->sharedData());
    }

    public function reference(string $slug): View
    {
        $reference = CitabicReference::query()->where('slug', $slug)->first();

        if (! $reference) {
            $reference = collect(config('citabic.references'))->firstWhere('slug', $slug);
        }

        abort_unless($reference, 404);

        $reference = $reference instanceof CitabicReference
            ? $this->transformReference($reference, app()->getLocale())
            : $this->hydrateReferenceArray($reference);

        return view('guest.pages.reference-detail', array_merge(
            $this->sharedData(),
            ['reference' => $reference]
        ));
    }

    public function blog(): View
    {
        $locale = app()->getLocale();
        $posts = Post::published()
            ->orderByDesc('published_at')
            ->get()
            ->map(fn($post) => $this->transformBlogPost($post, $locale));

        return view('guest.pages.blog', array_merge(
            $this->sharedData(),
            ['posts' => $posts]
        ));
    }

    public function blogPost(string $slug): View
    {
        $locale = app()->getLocale();
        $post = Post::where('slug', $slug)
            ->published()
            ->firstOrFail();

        $post = $this->transformBlogPost($post, $locale);

        return view('guest.pages.blog-detail', array_merge(
            $this->sharedData(),
            ['post' => $post]
        ));
    }

    public function contact(): View
    {
        return view('guest.pages.contact', $this->sharedData());
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'number' => ['nullable', 'string', 'max:255'],
            'message' => ['nullable', 'string'],
        ]);

        return response(__('site.contact.success'), 200)
            ->header('Content-Type', 'text/plain');
    }

    private function sharedData(): array
    {
        $locale = app()->getLocale();
        $profile = CitabicProfile::query()->first();
        $references = CitabicReference::query()->orderBy('sort_order')->get();

        if (! $profile) {
            $site = config('citabic');
            $site['hero_video_path'] = null;
            $site['hero_video_url'] = null;
            $site['references'] = collect($site['references'])
                ->map(fn (array $reference) => $this->hydrateReferenceArray($reference))
                ->all();

            return [
                'site' => $site,
                'references' => $site['references'],
                'company' => $site['company'],
            ];
        }

        $translatedSite = $this->transformProfile($profile, $locale);

        $site = [
            'company' => [
                'name' => $translatedSite['name'],
                'tagline' => $translatedSite['tagline'],
                'full_name' => $translatedSite['full_name'],
                'legal_name' => $translatedSite['legal_name'],
                'legal_form' => $translatedSite['legal_form'],
                'capital' => $translatedSite['capital'],
                'head_office' => $translatedSite['head_office'],
                'ice' => $translatedSite['ice'],
                'created_at' => $translatedSite['created_at'],
                'rc' => $translatedSite['rc'],
                'status' => $translatedSite['status'],
                'phone' => $translatedSite['phone'],
                'email' => $translatedSite['email'],
            ],
            'hero_video_path' => $translatedSite['hero_video_path'],
            'hero_video_url' => $this->resolveMediaUrl($translatedSite['hero_video_path']),
            'intro' => $translatedSite['intro'],
            'market_context' => $translatedSite['market_context'],
            'mission' => $translatedSite['mission'],
            'values' => $translatedSite['values'],
            'human_values' => $translatedSite['human_values'],
            'domains' => $translatedSite['domains'],
            'certifications' => $translatedSite['certifications'],
            'information_system' => $translatedSite['information_system'],
            'figures' => $translatedSite['figures'],
            'partnerships' => $translatedSite['partnerships'],
            'compliance' => $translatedSite['compliance'],
            'organization' => $translatedSite['organization'],
            'processes' => $translatedSite['processes'],
            'mission' => $translatedSite['mission'],
            'why_choose_us' => $translatedSite['why_choose_us'],
            'references' => $references->map(fn (CitabicReference $reference) => $this->transformReference($reference, $locale))->all(),
        ];

        return [
            'site' => $site,
            'references' => $site['references'],
            'company' => $site['company'],
        ];
    }

    private function transformProfile(CitabicProfile $profile, string $locale): array
    {
        $infoFields = [
            'intro', 'market_context', 'mission', 'certifications',
            'partnerships', 'compliance', 'organization', 'why_choose_us'
        ];

        $infos = [];
        foreach ($infoFields as $field) {
            $infos[$field] = $profile->getInfo($field)->map(function ($info) use ($locale) {
                if ($locale === 'fr') {
                    return $info->content;
                }
                return $info->translations[$locale] ?? $info->content;
            })->all();
        }

        $base = [
            'name' => $profile->name,
            'tagline' => $profile->tagline,
            'full_name' => $profile->full_name,
            'legal_name' => $profile->legal_name,
            'legal_form' => $profile->legal_form,
            'capital' => $profile->capital,
            'head_office' => $profile->head_office,
            'ice' => $profile->ice,
            'created_at' => $profile->company_created_at,
            'rc' => $profile->rc,
            'status' => $profile->status,
            'phone' => $profile->phone,
            'email' => $profile->email,
            'hero_video_path' => $profile->hero_video_path,
            'intro' => $infos['intro'],
            'market_context' => $infos['market_context'],
            'mission' => $infos['mission'],
            'values' => $profile->values()->get()->map(function ($value) use ($locale) {
                if ($locale === 'fr') {
                    return [
                        'title' => $value->title,
                        'text' => $value->text,
                    ];
                }
                $translations = $value->translations[$locale] ?? [];
                return [
                    'title' => $translations['title'] ?? $value->title,
                    'text' => $translations['text'] ?? $value->text,
                ];
            })->all(),
            'human_values' => $profile->human_values()->get()->map(function ($value) use ($locale) {
                if ($locale === 'fr') {
                    return [
                        'title' => $value->title,
                        'text' => $value->text,
                    ];
                }
                $translations = $value->translations[$locale] ?? [];
                return [
                    'title' => $translations['title'] ?? $value->title,
                    'text' => $translations['text'] ?? $value->text,
                ];
            })->all(),
            'domains' => $profile->domains()->get()->map(function ($domain) use ($locale) {
                if ($locale === 'fr') {
                    return [
                        'title' => $domain->title,
                        'items' => $domain->items,
                    ];
                }
                $translations = $domain->translations[$locale] ?? [];
                return [
                    'title' => $translations['title'] ?? $domain->title,
                    'items' => $translations['items'] ?? $domain->items,
                ];
            })->all(),
            'certifications' => $infos['certifications'],
            'information_system' => $profile->information_system,
            'figures' => $profile->figures()->get()->map(function ($figure) use ($locale) {
                if ($locale === 'fr') {
                    return [
                        'label' => $figure->label,
                        'value' => $figure->value,
                    ];
                }
                $translations = $figure->translations[$locale] ?? [];
                return [
                    'label' => $translations['label'] ?? $figure->label,
                    'value' => $translations['value'] ?? $figure->value,
                ];
            })->all(),
            'partnerships' => $infos['partnerships'],
            'compliance' => $infos['compliance'],
            'organization' => $infos['organization'],
            'processes' => $profile->processes()->get()->map(function ($process) use ($locale) {
                if ($locale === 'fr') {
                    return [
                        'title' => $process->title,
                        'description' => $process->description,
                    ];
                }
                $translations = $process->translations[$locale] ?? [];
                return [
                    'title' => $translations['title'] ?? $process->title,
                    'description' => $translations['description'] ?? $process->description,
                ];
            })->all(),
            'why_choose_us' => $infos['why_choose_us'],
        ];

        if ($locale === 'fr') {
            return $base;
        }

        $translations = $profile->translations[$locale] ?? [];
        $companyTranslations = $translations['company'] ?? [];

        return array_merge($base, [
            'tagline' => $companyTranslations['tagline'] ?? ($translations['tagline'] ?? $base['tagline']),
            'full_name' => $companyTranslations['full_name'] ?? ($translations['full_name'] ?? $base['full_name']),
            'legal_form' => $companyTranslations['legal_form'] ?? ($translations['legal_form'] ?? $base['legal_form']),
            'status' => $companyTranslations['status'] ?? ($translations['status'] ?? $base['status']),
            'information_system' => $translations['information_system'] ?? $base['information_system'],
        ]);
    }

    private function transformReference(CitabicReference $reference, string $locale): array
    {
        $base = $reference->toArray();

        if ($locale === 'fr') {
            return $this->hydrateReferenceArray($base);
        }

        return $this->hydrateReferenceArray(array_merge($base, $reference->translations[$locale] ?? []));
    }

    private function transformBlogPost(Post $post, string $locale): array
    {
        $base = $post->toArray();
        $translations = $post->translations[$locale] ?? [];

        if ($locale !== 'fr') {
            $base = array_merge($base, $translations);
        }

        $base['image_url'] = $this->resolveMediaUrl($base['featured_image'] ?? null);

        return $base;
    }

    private function hydrateReferenceArray(array $reference): array
    {
        $imagePath = $this->normalizeAssetPath($reference['image'] ?? null);

        $reference['image'] = $imagePath;
        $reference['image_url'] = $this->resolveMediaUrl($imagePath);

        return $reference;
    }

    private function resolveMediaUrl(?string $path): ?string
    {
        $path = $this->normalizeAssetPath($path);

        if (! $path) {
            return null;
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        if (
            str_starts_with($path, 'assets/')
            || str_starts_with($path, 'guest/assets/')
            || str_starts_with($path, 'storage/')
        ) {
            return asset($path);
        }

        return Storage::disk('public')->url($path);
    }

    private function normalizeAssetPath(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (str_starts_with($path, 'assets/')) {
            return 'guest/' . $path;
        }

        return $path;
    }
}
