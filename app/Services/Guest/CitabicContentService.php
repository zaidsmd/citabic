<?php

namespace App\Services\Guest;

use App\Enums\CompanyInfoKey;
use App\Enums\ContentKey;
use App\Enums\Section;
use App\Models\Category;
use App\Models\Certification;
use App\Models\CitabicDomain;
use App\Models\CitabicProfile;
use App\Models\CitabicReference;
use App\Models\CompanyInfo;
use App\Models\Mission;
use App\Models\Post;
use App\Models\SectionContent;
use App\Models\Tag;
use App\Services\GuestPageCache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Provides domain logic for Citabic Content Service.
 */
class CitabicContentService
{
    /**
     * Create a new instance with injected dependencies.
     *
     * @param  GuestPageCache  $guestPageCache  Parameter.
     * @return mixed
     */
    public function __construct(private GuestPageCache $guestPageCache) {}

    /**
     * Build and cache company page content payload.

     *

     * @param  string  $locale  Parameter.
     */
    public function getCompanyPageData(string $locale): array
    {
        $cacheKey = $this->guestPageCache->key("company_page_{$locale}");

        return Cache::remember($cacheKey, now()->addHours(6), function () use ($locale): array {
            $sc = fn (Section $section, ContentKey $key) => SectionContent::where('section', $section)
                ->where('key', $key)
                ->where('language', $locale)
                ->first()?->value
                ?? SectionContent::where('section', $section)
                    ->where('key', $key)
                    ->where('language', 'fr')
                    ->first()?->value
                ?? SectionContent::where('section', $section)
                    ->where('key', $key)
                    ->first()?->value;

            $scAny = fn (Section $section, ContentKey $key) => SectionContent::where('section', $section)
                ->where('key', $key)
                ->first()?->value;

            return [
                'about_header_bg' => $scAny(Section::ABOUT_PAGE, ContentKey::ABOUT_HEADER_BG_IMG),
                'about_title' => $sc(Section::ABOUT_PAGE, ContentKey::ABOUT_TITLE),
                'about_text' => $sc(Section::ABOUT_PAGE, ContentKey::ABOUT_TEXT),
                'rounded_text' => $sc(Section::ABOUT_PAGE, ContentKey::ROUNDED_TEXT),
                'section_image' => $scAny(Section::ABOUT_PAGE, ContentKey::SECTION_IMAGE),
                'mission_title' => $sc(Section::ABOUT_PAGE, ContentKey::MISSION_TITLE),
                'mission_text' => $sc(Section::ABOUT_PAGE, ContentKey::MISSION_TEXT),
                'why_us_title' => $sc(Section::ABOUT_PAGE, ContentKey::WHY_US_TITLE),
                'why_us_text' => $sc(Section::ABOUT_PAGE, ContentKey::WHY_US_TEXT),
                'why_us_cards' => explode(';', $sc(Section::ABOUT_PAGE, ContentKey::WHY_US_CARDS) ?? ''),
                'organigrame_title' => $sc(Section::ABOUT_PAGE, ContentKey::ORGANIGRAME_TITLE),
                'organigrame' => $scAny(Section::ABOUT_PAGE, ContentKey::ORGANIGRAME),
                'cartographie_title' => $sc(Section::ABOUT_PAGE, ContentKey::CARTOGRAPHIE_TITLE),
                'cartographie' => $scAny(Section::ABOUT_PAGE, ContentKey::CARTOGRAPHIE),
                'contact_form_text' => $sc(Section::CONTACT, ContentKey::CONTACT_FORM_TEXT),
                'contact_image' => $scAny(Section::CONTACT, ContentKey::CONTACT_IMAGE),
                'map_embed' => SectionContent::where('section', Section::CONTACT)
                    ->where('key', ContentKey::MAP_EMBED)
                    ->first()?->value,
                'domains' => CitabicDomain::all(),
                'missions' => Mission::with('translations')->get(),
                'certifications' => Certification::where('language', $locale)->get(),
            ];
        });
    }

    /**
     * Build a paginator for references with locale-aware mapping.

     *

     * @param  string  $locale  Parameter.
     */
    public function getReferencesPaginator(string $locale, int $perPage = 9, int $currentPage = 1): LengthAwarePaginator
    {
        if (CitabicReference::query()->exists()) {
            $referencePaginator = CitabicReference::query()
                ->orderBy('sort_order')
                ->paginate($perPage)
                ->withQueryString();

            $referencePaginator->setCollection(
                $referencePaginator->getCollection()->map(
                    fn (CitabicReference $reference): array => $this->transformReference($reference, $locale)
                )->values()
            );

            return $referencePaginator;
        }

        $referenceCollection = collect(config('citabic.references'))
            ->map(fn (array $reference): array => $this->hydrateReferenceArray($reference))
            ->values();

        return new LengthAwarePaginator(
            $referenceCollection->forPage($currentPage, $perPage)->values(),
            $referenceCollection->count(),
            $perPage,
            $currentPage,
            ['path' => url()->current(), 'query' => request()->query()]
        );
    }

    /**
     * Resolve a reference by slug with locale-aware transformation.

     *

     * @param string $slug Parameter.

     * @param  string  $locale  Parameter.
     */
    public function findReferenceBySlug(string $slug, string $locale): array
    {
        $reference = CitabicReference::query()->where('slug', $slug)->first();

        if (! $reference) {
            $reference = collect(config('citabic.references'))->firstWhere('slug', $slug);
        }

        abort_unless($reference, 404);

        return $reference instanceof CitabicReference
            ? $this->transformReference($reference, $locale)
            : $this->hydrateReferenceArray($reference);
    }

    /**
     * Build and cache blog listing payload.

     *

     * @param  string  $locale  Parameter.
     */
    public function getBlogListingData(string $locale, ?Category $category = null, ?Tag $tag = null, string $search = ''): array
    {
        $scope = 'index';
        if ($category) {
            $scope = 'category:'.$category->slug;
        } elseif ($tag) {
            $scope = 'tag:'.$tag->slug;
        }

        $perPage = 6;
        $page = max(1, (int) request('page', 1));
        $cacheKey = 'blog_listing:'.$locale.':'.$scope.':'.md5(mb_strtolower($search)).':p'.$page.':pp'.$perPage;
        $cacheKey = $this->guestPageCache->key($cacheKey);

        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($category, $tag, $locale, $search, $perPage): array {
            $query = Post::query()->published();

            if ($category) {
                $query = $category->posts()->published();
            } elseif ($tag) {
                $query = $tag->posts()->published();
            }

            $this->applyBlogSearch($query, $search);

            $postModels = $query
                ->with(['author:id,name', 'categories:id,name,slug', 'tags:id,name,slug'])
                ->orderByDesc('published_at')
                ->paginate($perPage)
                ->withQueryString();

            $postMeta = $postModels->getCollection()->keyBy('id');
            $postModels->setCollection(
                $postModels->getCollection()->map(
                    fn (Post $post): array => $this->transformBlogPost($post, $locale)
                )->values()
            );

            $recentPosts = Post::query()
                ->published()
                ->with('author:id,name')
                ->orderByDesc('published_at')
                ->limit(3)
                ->get()
                ->map(fn (Post $post): array => $this->transformBlogPost($post, $locale));

            return [
                'posts' => $postModels,
                'postMeta' => $postMeta,
                'recentPosts' => $recentPosts,
                'popularCategories' => Category::query()
                    ->withCount('posts')
                    ->orderByDesc('posts_count')
                    ->limit(6)
                    ->get(),
                'popularTags' => Tag::query()
                    ->withCount('posts')
                    ->orderByDesc('posts_count')
                    ->limit(8)
                    ->get(),
            ];
        });
    }

    /**
     * Build and cache home page content payload.

     *

     * @param  string  $locale  Parameter.
     */
    public function getHomePageData(string $locale): array
    {
        $cacheKey = 'home_page:'.$locale;
        $cacheKey = $this->guestPageCache->key($cacheKey);

        return Cache::remember($cacheKey, now()->addDays(30), function () use ($locale): array {
            $contentRows = SectionContent::query()
                ->whereIn('section', [
                    Section::HERO->value,
                    Section::ABOUT->value,
                    Section::ABOUT_PAGE->value,
                    Section::DOMAIN->value,
                    Section::WHY_CHOOSE_US->value,
                    Section::HOME->value,
                    Section::PROJECTS->value,
                    Section::CONTACT->value,
                ])
                ->get(['section', 'key', 'value', 'language'])
                ->groupBy(fn (SectionContent $content): string => $content->section.'|'.$content->key);

            $content = function (Section $section, ContentKey $key) use ($contentRows, $locale): ?string {
                $entries = $contentRows->get($section->value.'|'.$key->value, collect());

                return $entries->firstWhere('language', $locale)?->value
                    ?? $entries->firstWhere('language', 'fr')?->value
                    ?? $entries->first()?->value;
            };

            $homeRecentPosts = Post::query()
                ->published()
                ->orderByDesc('published_at')
                ->limit(8)
                ->get()
                ->map(function (Post $post) use ($locale): array {
                    $translations = is_array($post->translations ?? null) ? $post->translations : [];
                    $localized = $locale === 'fr' ? [] : ($translations[$locale] ?? []);

                    $title = $localized['title'] ?? $post->title;
                    $excerpt = $localized['excerpt'] ?? $post->excerpt ?? Str::limit(strip_tags($post->content ?? ''), 150);

                    return [
                        'slug' => $post->slug,
                        'title' => $title,
                        'excerpt' => $excerpt,
                        'image_url' => $this->resolveMediaUrl($post->featured_image) ?? asset('guest/assets/img/blog/blog_3_1.jpg'),
                        'published_at_label' => ($post->published_at ?? $post->created_at)?->format('F d, Y'),
                        'reading_time' => (int) ($post->reading_time ?? 0),
                    ];
                })->all();

            $homeProjectReferences = CitabicReference::query()
                ->orderBy('sort_order')
                ->limit(12)
                ->get()
                ->map(function (CitabicReference $reference) use ($locale): array {
                    $translatedReference = $this->transformReference($reference, $locale);
                    $blocks = collect($reference->blocks ?? []);
                    $coverImagePath = $blocks
                        ->first(fn ($block): bool => is_array($block) && ($block['type'] ?? null) === 'coverImage')['content'] ?? null;

                    if (is_string($coverImagePath)) {
                        $coverImagePath = str_replace('storage/', '', $coverImagePath);
                    }

                    return [
                        'slug' => $reference->slug,
                        'title' => $translatedReference['title'] ?? $reference->title,
                        'client' => $translatedReference['client'] ?? $reference->client,
                        'cover_image_url' => $this->resolveMediaUrl($coverImagePath) ?? $this->resolveMediaUrl($reference->image) ?? asset('guest/assets/img/project/project_1_1.jpg'),
                    ];
                })->all();

            $localizedDomains = CitabicDomain::query()
                ->orderBy('sort_order')
                ->get()
                ->map(function (CitabicDomain $domain) use ($locale): array {
                    $translations = is_array($domain->translations ?? null) ? $domain->translations : [];
                    $localized = $locale === 'fr' ? [] : ($translations[$locale] ?? []);

                    return [
                        'title' => $localized['title'] ?? $domain->title,
                        'items' => $localized['items'] ?? $domain->items ?? [],
                        'icon_url' => $this->resolveMediaUrl($domain->icon),
                    ];
                })->all();

            $valuesSubtitle = $content(Section::HOME, ContentKey::VALUES_SUBTITLE) ?: __('site.company.block_label');
            $valuesTitle = $content(Section::HOME, ContentKey::VALUES_TITLE) ?: __('site.home.values.title');
            $blogSubtitle = $content(Section::HOME, ContentKey::BLOG_SUBTITLE) ?: __('site.home.blog.subtitle');
            $blogTitle = $content(Section::HOME, ContentKey::BLOG_TITLE) ?: __('site.home.blog.title');
            $blogText = $content(Section::HOME, ContentKey::BLOG_TEXT) ?: __('site.home.blog.text');
            $contactTitle = $content(Section::CONTACT, ContentKey::CONTACT_FORM_TEXT) ?: __('site.contact.title');

            $metaTitle = $content(Section::HOME, ContentKey::META_TITLE) ?: __('site.home.seo.title');
            $metaDescription = $content(Section::HOME, ContentKey::META_DESCRIPTION) ?: __('site.home.seo.description');
            $metaKeywords = $content(Section::HOME, ContentKey::META_KEYWORDS) ?: __('site.home.seo.keywords');
            $homeOgImage = $this->resolveMediaUrl($content(Section::CONTACT, ContentKey::CONTACT_IMAGE));

            return [
                'seo' => [
                    'title' => 'CITABIC | '.$metaTitle,
                    'description' => strip_tags($metaDescription),
                    'keywords' => $metaKeywords,
                    'og_title' => 'CITABIC | '.$metaTitle,
                    'og_description' => strip_tags($metaDescription),
                    'og_image' => $homeOgImage ?? '',
                    'twitter_card' => 'summary_large_image',
                ],
                'hero' => [
                    'subtitle' => $content(Section::HERO, ContentKey::HERO_SUBTITLE),
                    'title' => $content(Section::HERO, ContentKey::HERO_TITLE),
                    'cta_text' => __('site.home.hero.discover_more'),
                    'circle_text' => $content(Section::ABOUT_PAGE, ContentKey::ROUNDED_TEXT) ?: __('site.home.hero.circle_text'),
                ],
                'about' => [
                    'image_1_url' => $this->resolveMediaUrl($content(Section::ABOUT, ContentKey::ABOUT_IMAGE_1)),
                    'image_2_url' => $this->resolveMediaUrl($content(Section::ABOUT, ContentKey::ABOUT_IMAGE_2)),
                    'image_3_url' => $this->resolveMediaUrl($content(Section::ABOUT, ContentKey::ABOUT_IMAGE_3)),
                    'rounded_text' => $content(Section::ABOUT_PAGE, ContentKey::ROUNDED_TEXT),
                    'subtitle' => $content(Section::ABOUT, ContentKey::ABOUT_SUBTITLE),
                    'title' => $content(Section::ABOUT, ContentKey::ABOUT_TITLE),
                    'text' => $content(Section::ABOUT, ContentKey::ABOUT_TEXT),
                ],
                'domains' => [
                    'subtitle' => $content(Section::DOMAIN, ContentKey::DOMAIN_SUBTITLE),
                    'title' => $content(Section::DOMAIN, ContentKey::DOMAIN_TITLE),
                    'text' => $content(Section::DOMAIN, ContentKey::DOMAIN_TEXT),
                    'items' => $localizedDomains,
                ],
                'why' => [
                    'image_url' => $this->resolveMediaUrl($content(Section::WHY_CHOOSE_US, ContentKey::WHY_IMAGE)),
                    'subtitle' => $content(Section::WHY_CHOOSE_US, ContentKey::WHY_SUBTITLE),
                    'title' => $content(Section::WHY_CHOOSE_US, ContentKey::WHY_TITLE),
                    'text' => $content(Section::WHY_CHOOSE_US, ContentKey::WHY_TEXT),
                ],
                'values' => [
                    'subtitle' => $valuesSubtitle,
                    'title' => $valuesTitle,
                    'text' => $content(Section::HOME, ContentKey::VALUES_TEXT) ?? '',
                    'empty_text' => __('site.home.values.empty'),
                ],
                'projects' => [
                    'subtitle' => $content(Section::PROJECTS, ContentKey::PROJECTS_SUBTITLE),
                    'title' => $content(Section::PROJECTS, ContentKey::PROJECTS_TITLE),
                    'text' => $content(Section::PROJECTS, ContentKey::PROJECTS_TEXT),
                    'items' => $homeProjectReferences,
                ],
                'contact' => [
                    'subtitle' => __('site.home.contact.subtitle'),
                    'form_title' => $contactTitle,
                    'contact_image_url' => $this->resolveMediaUrl($content(Section::CONTACT, ContentKey::CONTACT_IMAGE)),
                    'map_embed' => $content(Section::CONTACT, ContentKey::MAP_EMBED),
                    'submit_text' => __('site.home.contact.submit'),
                    'message_placeholder' => __('site.contact.message_placeholder'),
                ],
                'blog' => [
                    'subtitle' => $blogSubtitle,
                    'title' => $blogTitle,
                    'text' => $blogText,
                    'browse_text' => __('site.home.blog.browse_all'),
                    'read_more_text' => __('site.blog.listing.read_more'),
                    'min_read_text' => __('site.home.blog.min_read'),
                    'empty_text' => __('site.home.blog.empty'),
                    'posts' => $homeRecentPosts,
                ],
            ];
        });
    }

    /**
     * Build shared view data used by public pages.
     */
    public function sharedData(): array
    {
        $locale = app()->getLocale();
        $profile = CitabicProfile::query()->first();
        $references = CitabicReference::query()->orderBy('sort_order')->get();
        $companyInfo = Cache::remember(
            $this->guestPageCache->key('company_info:fr'),
            now()->addHours(6),
            static fn (): array => CompanyInfo::getAllInfo()
        );

        $heroVideoPath = SectionContent::where('section', Section::HERO)
            ->where('key', ContentKey::HERO_VIDEO->value)
            ->value('value');
        $whyFeaturesRaw = SectionContent::where('section', Section::WHY_CHOOSE_US->value)
            ->where('key', ContentKey::WHY_FEATURES->value)
            ->where('language', $locale)
            ->value('value')
            ?? SectionContent::where('section', Section::WHY_CHOOSE_US->value)
                ->where('key', ContentKey::WHY_FEATURES->value)
                ->where('language', 'fr')
                ->value('value');
        $whyFeatures = json_decode($whyFeaturesRaw ?? '[]', true) ?: [];

        $heroAssets = $this->resolveHeroVideoAssets($heroVideoPath);

        if (! $profile) {
            $site = config('citabic');
            $site = array_merge($site, $heroAssets);
            $site['references'] = collect($site['references'])
                ->map(fn (array $reference) => $this->hydrateReferenceArray($reference))
                ->all();

            $site['why_features'] = $whyFeatures;

            return [
                'site' => $site,
                'references' => $site['references'],
                'company' => array_merge($site['company'], [
                    'facebook' => $companyInfo[CompanyInfoKey::FACEBOOK->value] ?? null,
                    'linkedin' => $companyInfo[CompanyInfoKey::LINKEDIN->value] ?? null,
                    'instagram' => $companyInfo[CompanyInfoKey::INSTAGRAM->value] ?? null,
                ]),
                'why_features' => $whyFeatures,
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
                'facebook' => $companyInfo[CompanyInfoKey::FACEBOOK->value] ?? null,
                'linkedin' => $companyInfo[CompanyInfoKey::LINKEDIN->value] ?? null,
                'instagram' => $companyInfo[CompanyInfoKey::INSTAGRAM->value] ?? null,
            ],
            'hero_video_path' => $heroAssets['hero_video_path'],
            'hero_video_url' => $heroAssets['hero_video_url'],
            'hero_video_stream_url' => $heroAssets['hero_video_stream_url'],
            'hero_video_webm_url' => $heroAssets['hero_video_webm_url'],
            'hero_video_poster_url' => $heroAssets['hero_video_poster_url'],
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
            'why_features' => $whyFeatures,
            'references' => $references->map(fn (CitabicReference $reference) => $this->transformReference($reference, $locale))->all(),
        ];

        return [
            'site' => $site,
            'references' => $site['references'],
            'company' => $site['company'],
            'why_features' => $whyFeatures,
        ];
    }

    /**
     * Build and cache contact page content payload.

     *

     * @param  string  $locale  Parameter.
     */
    public function getContactPageData(string $locale): array
    {
        $cacheKey = 'contact_page:'.$locale;
        $cacheKey = $this->guestPageCache->key($cacheKey);

        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($locale): array {
            $content = fn (ContentKey $key): ?string => SectionContent::query()
                ->where('section', Section::CONTACT->value)
                ->where('key', $key->value)
                ->where('language', $locale)
                ->value('value')
                ?? SectionContent::query()
                    ->where('section', Section::CONTACT->value)
                    ->where('key', $key->value)
                    ->where('language', 'fr')
                    ->value('value');

            $formTitle = $content(ContentKey::CONTACT_FORM_TEXT) ?: __('site.contact.title');
            $metaTitle = $content(ContentKey::CONTACT_TITLE) ?: __('site.contact.seo.title');
            $metaDescription = strip_tags($formTitle) ?: __('site.contact.seo.description');
            $contactImagePath = $content(ContentKey::CONTACT_IMAGE);

            return [
                'form_title' => $formTitle,
                'map_embed' => $content(ContentKey::MAP_EMBED),
                'contact_image_path' => $contactImagePath,
                'contact_image_url' => $this->resolveMediaUrl($contactImagePath),
                'seo' => [
                    'title' => 'CITABIC | '.$metaTitle,
                    'description' => $metaDescription,
                    'keywords' => __('site.contact.seo.keywords'),
                    'og_title' => 'CITABIC | '.$metaTitle,
                    'og_description' => $metaDescription,
                    'og_image' => $this->resolveMediaUrl($contactImagePath) ?? '',
                    'twitter_card' => 'summary_large_image',
                ],
            ];
        });
    }

    /**
     * Transform a post model into a localized view payload.

     *

     * @param Post $post Parameter.

     * @param  string  $locale  Parameter.
     */
    public function transformBlogPost(Post $post, string $locale): array
    {
        $base = $post->toArray();
        $translations = $post->translations[$locale] ?? [];

        if ($locale !== 'fr') {
            $base = array_merge($base, $translations);
        }

        $base['image_url'] = $this->resolveMediaUrl($base['featured_image'] ?? null);

        return $base;
    }

    private function transformProfile(CitabicProfile $profile, string $locale): array
    {
        $infoFields = [
            'intro', 'market_context', 'mission', 'certifications',
            'partnerships', 'compliance', 'organization', 'why_choose_us',
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
                        'image' => $value->image,
                        'image_url' => $this->resolveMediaUrl($value->image),
                    ];
                }
                $translations = $value->translations[$locale] ?? [];

                return [
                    'title' => $translations['title'] ?? $value->title,
                    'text' => $translations['text'] ?? $value->text,
                    'image' => $value->image,
                    'image_url' => $this->resolveMediaUrl($value->image),
                ];
            })->all(),
            'human_values' => $profile->human_values()->get()->map(function ($value) use ($locale) {
                if ($locale === 'fr') {
                    return [
                        'title' => $value->title,
                        'text' => $value->text,
                        'image' => $value->image,
                        'image_url' => $this->resolveMediaUrl($value->image),
                    ];
                }
                $translations = $value->translations[$locale] ?? [];

                return [
                    'title' => $translations['title'] ?? $value->title,
                    'text' => $translations['text'] ?? $value->text,
                    'image' => $value->image,
                    'image_url' => $this->resolveMediaUrl($value->image),
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

        $localized = array_merge($base, $reference->translations[$locale] ?? []);

        if (! empty($localized['blocks']) && is_array($localized['blocks'])) {
            $suffix = $locale === 'en' ? '_en' : ($locale === 'ar' ? '_ar' : '');
            if ($suffix !== '') {
                $localized['blocks'] = array_map(function ($block) use ($suffix) {
                    if (is_array($block) && isset($block['content'.$suffix]) && trim((string) $block['content'.$suffix]) !== '') {
                        $block['content'] = $block['content'.$suffix];
                    }

                    return $block;
                }, $localized['blocks']);
            }
        }

        return $this->hydrateReferenceArray($localized);
    }

    private function applyBlogSearch(Builder|BelongsToMany $query, string $search): void
    {
        if ($search === '') {
            return;
        }

        $likeTerm = '%'.$search.'%';

        $query->where(function (Builder $builder) use ($likeTerm): void {
            $builder
                ->where('title', 'like', $likeTerm)
                ->orWhere('excerpt', 'like', $likeTerm)
                ->orWhere('content', 'like', $likeTerm);
        });
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

        return Storage::disk('public')->url(str_replace('storage/', '', $path));
    }

    private function normalizeAssetPath(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (str_starts_with($path, 'assets/')) {
            return 'guest/'.$path;
        }

        return $path;
    }

    private function resolveHeroVideoAssets(?string $heroVideoPath): array
    {
        if (! $heroVideoPath) {
            return [
                'hero_video_path' => null,
                'hero_video_url' => null,
                'hero_video_stream_url' => null,
                'hero_video_webm_url' => null,
                'hero_video_poster_url' => null,
            ];
        }

        $directUrl = $this->resolveMediaUrl($heroVideoPath);
        $disk = Storage::disk('public');
        $relativeClean = str_replace('storage/', '', $this->normalizeAssetPath($heroVideoPath) ?? '');

        $streamUrl = $relativeClean && $disk->exists($relativeClean)
            ? route('media.stream', ['path' => $relativeClean])
            : $directUrl;

        $webmUrl = null;
        $posterUrl = null;

        if ($relativeClean) {
            $basePathWithoutExt = preg_replace('/\.[^.]+$/', '', $relativeClean);

            $webmPath = $basePathWithoutExt.'.webm';
            if ($disk->exists($webmPath)) {
                $webmUrl = route('media.stream', ['path' => $webmPath]);
            }

            $posterWebp = $basePathWithoutExt.'-poster.webp';
            $posterJpg = $basePathWithoutExt.'-poster.jpg';
            if ($disk->exists($posterWebp)) {
                $posterUrl = $disk->url($posterWebp);
            } elseif ($disk->exists($posterJpg)) {
                $posterUrl = $disk->url($posterJpg);
            }
        }

        return [
            'hero_video_path' => $heroVideoPath,
            'hero_video_url' => $directUrl,
            'hero_video_stream_url' => $streamUrl,
            'hero_video_webm_url' => $webmUrl,
            'hero_video_poster_url' => $posterUrl,
        ];
    }
}
