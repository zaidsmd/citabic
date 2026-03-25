<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Services\ImageUploadService;
use App\Services\PostTranslationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['author', 'categories'])->latest()->paginate(10);

        return view('admin.cms.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        $post = new Post; // For the form view to use safely

        return view('admin.cms.posts.form', compact('categories', 'tags', 'post'));
    }

    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();

        $validated['author_id'] = auth()->id() ?? 1;
        $validated['featured'] = $request->has('featured');
        $validated['allow_comments'] = $request->has('allow_comments');
        $validated['translations'] = ['en' => $request->en ?? []];
        $validated['content'] = $validated['content'] ?? '';
        $validated['blocks'] = $validated['blocks'] ?? [];
        $validated = $this->applyAutoSeoDefaults($validated);
        unset($validated['published_at']);

        if ($validated['status'] === PostStatus::Published->value) {
            $validated['published_at'] = now();
        }

        $post = Post::create($validated);

        $post->categories()->sync($this->resolveTaxonomyIds($request->input('categories', []), Category::class));
        $post->tags()->sync($this->resolveTaxonomyIds($request->input('tags', []), Tag::class));

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully.');
    }

    public function show(Post $post)
    {
        if ($post->status !== PostStatus::Published && (! auth()->check())) {
            abort(404);
        }

        $post->incrementViews();

        return view('admin.cms.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.cms.posts.form', compact('post', 'categories', 'tags'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $validated = $request->validated();

        $validated['featured'] = $request->has('featured');
        $validated['allow_comments'] = $request->has('allow_comments');
        $validated['translations'] = ['en' => $request->en ?? []];
        $validated['content'] = $validated['content'] ?? '';
        $validated['blocks'] = $validated['blocks'] ?? [];
        $validated = $this->applyAutoSeoDefaults($validated, $post);
        unset($validated['published_at']);

        if ($validated['status'] === PostStatus::Published->value && empty($post->published_at)) {
            $validated['published_at'] = now();
        }

        if ($validated['status'] !== PostStatus::Published->value) {
            $validated['published_at'] = null;
        }

        $post->update($validated);

        $post->categories()->sync($this->resolveTaxonomyIds($request->input('categories', []), Category::class));
        $post->tags()->sync($this->resolveTaxonomyIds($request->input('tags', []), Tag::class));

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully.');
    }

    public function publish(Post $post)
    {
        $post->publish();

        return redirect()
            ->route('admin.posts.index')
            ->with('success', __('admin.posts.messages.published'));
    }

    public function unpublish(Post $post)
    {
        $post->unpublish();

        return redirect()
            ->route('admin.posts.index')
            ->with('success', __('admin.posts.messages.unpublished'));
    }

    public function uploadFeaturedImage(Request $request, ImageUploadService $imageService): JsonResponse
    {
        $request->validate([
            'file' => 'required|image|max:5120',
        ]);

        $path = $imageService->store($request->file('file'), 'posts/featured');

        return response()->json([
            'path' => $path,
            'url' => Storage::disk('public')->url($path),
        ]);
    }

    public function translateFrToEn(Request $request, PostTranslationService $postTranslationService): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string'],
            'excerpt' => ['nullable', 'string'],
            'blocks' => ['nullable', 'array'],
        ]);

        try {
            $translated = $postTranslationService->translateFrToEn(
                $validated['title'] ?? '',
                $validated['excerpt'] ?? '',
                $validated['blocks'] ?? [],
            );

            return response()->json([
                'data' => $translated,
            ]);
        } catch (RuntimeException $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 422);
        }
    }

    /**
     * @param  array<int, mixed>  $values
     * @param  class-string<Category|Tag>  $modelClass
     * @return array<int, int>
     */
    private function resolveTaxonomyIds(array $values, string $modelClass): array
    {
        return collect($values)
            ->map(function (mixed $value) use ($modelClass): ?int {
                $rawValue = is_string($value) ? trim($value) : (string) $value;

                if ($rawValue === '') {
                    return null;
                }

                if (ctype_digit($rawValue)) {
                    $existingById = $modelClass::query()->find((int) $rawValue);
                    if ($existingById) {
                        return $existingById->id;
                    }
                }

                $slugBase = Str::slug($rawValue);
                if ($slugBase === '') {
                    $slugBase = Str::lower(Str::random(10));
                }

                $existing = $modelClass::query()->where('slug', $slugBase)->first();
                if ($existing) {
                    return $existing->id;
                }

                $uniqueSlug = $this->generateUniqueSlug($modelClass, $slugBase);

                return $modelClass::query()->create([
                    'name' => $rawValue,
                    'slug' => $uniqueSlug,
                ])->id;
            })
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    /**
     * @param  class-string<Category|Tag>  $modelClass
     */
    private function generateUniqueSlug(string $modelClass, string $baseSlug): string
    {
        $slug = $baseSlug;
        $counter = 1;

        while ($modelClass::query()->where('slug', $slug)->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    private function applyAutoSeoDefaults(array $validated, ?Post $post = null): array
    {
        $title = trim((string) ($validated['title'] ?? $post?->title ?? ''));
        $excerpt = trim((string) ($validated['excerpt'] ?? $post?->excerpt ?? ''));
        $content = trim((string) ($validated['content'] ?? $post?->content ?? ''));
        $featuredImage = trim((string) ($validated['featured_image'] ?? $post?->featured_image ?? ''));
        $slug = $post?->slug ?: Str::slug($title);

        if ($slug === '') {
            $slug = Str::lower(Str::random(10));
        }

        $titleWords = collect(explode(' ', Str::slug($title, ' ')))
            ->filter(fn (string $word): bool => mb_strlen($word) > 2)
            ->unique()
            ->values();

        $focusKeyword = $titleWords->take(3)->implode(' ');
        $metaKeywords = $titleWords->take(10)->implode(', ');
        $metaDescription = $excerpt !== '' ? $excerpt : Str::limit(strip_tags($content), 160, '');
        $twitterCard = $featuredImage !== '' ? 'summary_large_image' : 'summary';
        $manualMetaTitle = trim((string) ($validated['meta_title'] ?? $post?->meta_title ?? ''));
        $manualMetaDescription = trim((string) ($validated['meta_description'] ?? $post?->meta_description ?? ''));
        $manualMetaKeywords = trim((string) ($validated['meta_keywords'] ?? $post?->meta_keywords ?? ''));
        $manualFocusKeyword = trim((string) ($validated['focus_keyword'] ?? $post?->focus_keyword ?? ''));

        $validated['meta_title'] = $manualMetaTitle !== '' ? $manualMetaTitle : $title;
        $validated['meta_description'] = $manualMetaDescription !== '' ? $manualMetaDescription : $metaDescription;
        $validated['meta_keywords'] = $manualMetaKeywords !== '' ? $manualMetaKeywords : $metaKeywords;
        $validated['focus_keyword'] = $manualFocusKeyword !== '' ? $manualFocusKeyword : $focusKeyword;
        $validated['canonical_url'] = route('blog.show', $slug);
        $validated['og_title'] = $title;
        $validated['og_description'] = $metaDescription;
        $validated['og_image'] = $featuredImage;
        $validated['twitter_title'] = $title;
        $validated['twitter_description'] = $metaDescription;
        $validated['twitter_image'] = $featuredImage;
        $validated['twitter_card'] = $twitterCard;
        $validated['robots_index'] = true;
        $validated['robots_follow'] = true;
        $validated['schema_type'] = 'Article';

        return $validated;
    }
}
