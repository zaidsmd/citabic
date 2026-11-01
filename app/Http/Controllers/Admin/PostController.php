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

/**
 * Handles HTTP endpoints for Post Controller.
 */
class PostController extends Controller
{
    /**
     * Display a listing for the resource.
     *
     * @param  Request  $request  Parameter.
     * @return mixed
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Post::query()->with('categories')->latest();

            $table = datatables()->of($query)
                ->addColumn('image_preview', function (Post $post): string {
                    if ($post->featured_image) {
                        return '<img src="'.e($post->featured_image).'" alt="" style="height: 40px;">';
                    }

                    return '<span class="text-muted">'.e(__('admin.posts.index.no_image')).'</span>';
                })
                ->addColumn('status_badge', function (Post $post): string {
                    $status = $post->status instanceof PostStatus ? $post->status : PostStatus::tryFrom((string) $post->status);
                    $statusClass = match ($status) {
                        PostStatus::Published => 'bg-light-success',
                        PostStatus::Draft => 'bg-light-warning',
                        PostStatus::Archived => 'bg-light-secondary',
                        default => 'bg-light-secondary',
                    };

                    return '<span class="badge '.$statusClass.'">'.e($status?->label() ?? (string) $post->status).'</span>';
                })
                ->addColumn('categories_badges', function (Post $post): string {
                    if ($post->categories->isEmpty()) {
                        return '-';
                    }

                    return $post->categories
                        ->map(fn ($category) => '<span class="badge bg-light-info me-1">'.e($category->name).'</span>')
                        ->implode('');
                })
                ->addColumn('published_at_display', function (Post $post): string {
                    return $post->published_at ? $post->published_at->format('d M Y H:i') : '-';
                })
                ->addColumn('actions', function (Post $post): string {
                    $postUrl = route('blog.show', $post->slug);
                    $encodedUrl = urlencode($postUrl);
                    $fbShareUrl = 'https://www.facebook.com/sharer/sharer.php?u=' . $encodedUrl;
                    $liShareUrl = 'https://www.linkedin.com/sharing/share-offsite/?url=' . $encodedUrl;
                    $cleanExcerpt = $post->getCleanExcerpt();
                    $shareCaption = $post->getShareCaption();

                    $showButton = sprintf(
                        '<a href="%s" class="btn btn-sm btn-light-secondary me-1" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('admin.common.view').'"><i class="fa fa-eye"></i></a>',
                        $postUrl
                    );

                    $shareModalButton = sprintf(
                        '<button type="button" class="btn btn-sm btn-light-warning me-1 btn-open-post-share-modal" data-id="%s" data-url="%s" data-title="%s" data-summary="%s" data-caption="%s" data-fb="%s" data-li="%s" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('admin.posts.share_modal_title').'" aria-label="'.__('admin.posts.share_modal_title').'"><i class="ti ti-share text-warning"></i></button>',
                        $post->id,
                        $postUrl,
                        e($post->title),
                        e($cleanExcerpt),
                        e($shareCaption),
                        $fbShareUrl,
                        $liShareUrl
                    );

                    $facebookButton = sprintf(
                        '<a href="%s" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-light-primary me-1 btn-social-share" data-platform="facebook" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('admin.posts.share_facebook').'" aria-label="'.__('admin.posts.share_facebook').'"><i class="fab fa-facebook-f text-primary"></i></a>',
                        $fbShareUrl
                    );

                    $linkedinButton = sprintf(
                        '<a href="%s" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-light-info me-1 btn-social-share" data-platform="linkedin" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('admin.posts.share_linkedin').'" aria-label="'.__('admin.posts.share_linkedin').'"><i class="fab fa-linkedin-in text-info"></i></a>',
                        $liShareUrl
                    );

                    $editButton = sprintf(
                        '<a href="%s" class="btn btn-sm btn-light-primary me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('admin.common.edit').'" aria-label="'.__('admin.common.edit').'"><i class="fa fa-pen"></i></a>',
                        route('admin.posts.edit', $post),
                    );

                    $toggleButton = $post->status === PostStatus::Published
                        ? sprintf(
                            '<form action="%s" method="POST" class="d-inline me-1">%s%s<button type="submit" class="btn btn-sm btn-light-info"> <i class="fa fa-archive me-1"></i> %s</button></form>',
                            route('admin.posts.unpublish', $post),
                            csrf_field(),
                            method_field('PATCH'),
                            e(__('admin.posts.actions.unpublish'))
                        )
                        : sprintf(
                            '<form action="%s" method="POST" class="d-inline me-1">%s%s<button type="submit" class="btn btn-sm btn-light-success"> <i class="fa fa-paper-plane me-1"></i> %s</button></form>',
                            route('admin.posts.publish', $post),
                            csrf_field(),
                            method_field('PATCH'),
                            e(__('admin.posts.actions.publish'))
                        );

                    $deleteButton = sprintf(
                        '<button type="button" class="btn btn-sm btn-light-danger" data-table-action="delete" data-url="%s"><i class="fa fa-trash-alt"></i></button>',
                        route('admin.posts.destroy', $post),
                        e(__('admin.common.delete'))
                    );

                    return $showButton.$shareModalButton.$facebookButton.$linkedinButton.$toggleButton.$editButton.$deleteButton;
                })
                ->rawColumns(['image_preview', 'status_badge', 'categories_badges', 'actions']);

            return $table->make(true);
        }

        return view('admin.posts.index');
    }

    /**
     * Show the creation form for the resource.

     *

     * @return mixed
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        $post = new Post; // For the form view to use safely

        return view('admin.posts.form', compact('categories', 'tags', 'post'));
    }

    /**
     * Persist a newly created resource.

     *

     * @param StorePostRequest $request Parameter.

     * @return mixed
     */
    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();

        $validated['author_id'] = auth()->id() ?? 1;
        $validated['featured'] = $request->has('featured');
        $validated['allow_comments'] = $request->has('allow_comments');
        $validated['translations'] = [
            'en' => $request->en ?? [],
            'ar' => $request->ar ?? [],
        ];
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

    /**
     * Display the requested resource.

     *

     * @param Post $post Parameter.

     * @return mixed
     */
    public function show(Post $post)
    {
        if ($post->status !== PostStatus::Published && (! auth()->check())) {
            abort(404);
        }

        $post->incrementViews();

        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the edit form for the resource.

     *

     * @param Post $post Parameter.

     * @return mixed
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.form', compact('post', 'categories', 'tags'));
    }

    /**
     * Persist updates to the resource.

     *

     * @param UpdatePostRequest $request Parameter.

     * @param Post $post Parameter.

     * @return mixed
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $validated = $request->validated();

        $validated['featured'] = $request->has('featured');
        $validated['allow_comments'] = $request->has('allow_comments');
        $validated['translations'] = [
            'en' => $request->en ?? [],
            'ar' => $request->ar ?? [],
        ];
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

    /**
     * Delete the specified resource.

     *

     * @param Post $post Parameter.

     * @return mixed
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully.');
    }

    /**
     * Mark the resource as published.

     *

     * @param Post $post Parameter.

     * @return mixed
     */
    public function publish(Post $post)
    {
        $post->publish();

        return redirect()
            ->route('admin.posts.index')
            ->with('success', __('admin.posts.messages.published'));
    }

    /**
     * Mark the resource as unpublished.

     *

     * @param Post $post Parameter.

     * @return mixed
     */
    public function unpublish(Post $post)
    {
        $post->unpublish();

        return redirect()
            ->route('admin.posts.index')
            ->with('success', __('admin.posts.messages.unpublished'));
    }

    /**
     * Get social share data for a blog post.
     */
    public function postShareData(Post $post): JsonResponse
    {
        $url = route('blog.show', $post->slug);

        return response()->json([
            'id' => $post->id,
            'title' => $post->title,
            'url' => $url,
            'excerpt' => $post->getCleanExcerpt(),
            'caption' => $post->getShareCaption(),
            'facebook_url' => 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($url),
            'linkedin_url' => 'https://www.linkedin.com/sharing/share-offsite/?url=' . urlencode($url),
        ]);
    }


    /**
     * Upload featured image.

     *

     * @param Request $request Parameter.

     * @param  ImageUploadService  $imageService  Parameter.
     */
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

    /**
     * Translate fr to en.

     *

     * @param Request $request Parameter.

     * @param  PostTranslationService  $postTranslationService  Parameter.
     */
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
