<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostCommentRequest;
use App\Models\Category;
use App\Models\ContactSubmission;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Notifications\NewBlogCommentNotification;
use App\Notifications\NewContactSubmissionNotification;
use App\Services\Guest\CitabicContentService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification as BaseNotification;
use Illuminate\Support\Facades\Notification as NotificationFacade;
use Illuminate\View\View;

/**
 * Handles HTTP endpoints for Citabic Controller.
 */
class CitabicController extends Controller
{
    /**
     * Create a new instance with injected dependencies.
     *
     * @param  CitabicContentService  $contentService  Parameter.
     * @return mixed
     */
    public function __construct(private CitabicContentService $contentService) {}

    /**
     * Render the public home page.
     */
    public function home(): View
    {
        $locale = app()->getLocale();

        return view('guest.pages.home', array_merge(
            $this->contentService->sharedData(),
            ['homePage' => $this->contentService->getHomePageData($locale)]
        ));
    }

    /**
     * Render the public company page.
     */
    public function company(): View
    {
        $locale = app()->getLocale();
        $companyData = $this->contentService->getCompanyPageData($locale);

        return view('guest.pages.company', array_merge(
            $this->contentService->sharedData(),
            ['cp' => $companyData]
        ));
    }

    /**
     * Render the public references listing.
     */
    public function references(): View
    {
        $locale = app()->getLocale();
        $perPage = 9;
        $currentPage = max(1, (int) request('page', 1));
        $referencePaginator = $this->contentService->getReferencesPaginator($locale, $perPage, $currentPage);

        return view('guest.pages.references', array_merge(
            $this->contentService->sharedData(),
            ['references' => $referencePaginator]
        ));
    }

    /**
     * Render a single public reference detail page.

     *

     * @param  string  $slug  Parameter.
     */
    public function reference(string $slug): View
    {
        $reference = $this->contentService->findReferenceBySlug($slug, app()->getLocale());

        return view('guest.pages.reference-detail', array_merge(
            $this->contentService->sharedData(),
            ['reference' => $reference]
        ));
    }

    /**
     * Render the public blog listing page.
     */
    public function blog(): View
    {
        $locale = app()->getLocale();
        $search = trim((string) request('q', ''));
        $blogData = $this->contentService->getBlogListingData($locale, null, null, $search);

        return view('guest.pages.blog', array_merge(
            $this->contentService->sharedData(),
            [
                'posts' => $blogData['posts'],
                'postMeta' => $blogData['postMeta'],
                'recentPosts' => $blogData['recentPosts'],
                'popularCategories' => $blogData['popularCategories'],
                'popularTags' => $blogData['popularTags'],
                'search' => $search,
            ]
        ));
    }

    /**
     * Render the blog listing filtered by category.

     *

     * @param  string  $slug  Parameter.
     */
    public function blogByCategory(string $slug): View
    {
        $category = Category::query()->where('slug', $slug)->firstOrFail();
        $locale = app()->getLocale();
        $search = trim((string) request('q', ''));
        $blogData = $this->contentService->getBlogListingData($locale, $category, null, $search);

        return view('guest.pages.blog-category', array_merge(
            $this->contentService->sharedData(),
            [
                'posts' => $blogData['posts'],
                'postMeta' => $blogData['postMeta'],
                'recentPosts' => $blogData['recentPosts'],
                'popularCategories' => $blogData['popularCategories'],
                'popularTags' => $blogData['popularTags'],
                'filterType' => 'category',
                'filterName' => $category->name,
                'category' => $category,
                'search' => $search,
            ]
        ));
    }

    /**
     * Render the blog listing filtered by tag.

     *

     * @param  string  $slug  Parameter.
     */
    public function blogByTag(string $slug): View
    {
        $tag = Tag::query()->where('slug', $slug)->firstOrFail();
        $locale = app()->getLocale();
        $search = trim((string) request('q', ''));
        $blogData = $this->contentService->getBlogListingData($locale, null, $tag, $search);

        return view('guest.pages.blog-tag', array_merge(
            $this->contentService->sharedData(),
            [
                'posts' => $blogData['posts'],
                'postMeta' => $blogData['postMeta'],
                'recentPosts' => $blogData['recentPosts'],
                'popularCategories' => $blogData['popularCategories'],
                'popularTags' => $blogData['popularTags'],
                'filterType' => 'tag',
                'filterName' => $tag->name,
                'tag' => $tag,
                'search' => $search,
            ]
        ));
    }

    /**
     * Render the public blog post detail page.

     *

     * @param  string  $slug  Parameter.
     */
    public function blogPost(string $slug): View
    {
        $locale = app()->getLocale();
        $postModel = Post::query()
            ->with([
                'comments' => fn ($query) => $query
                    ->where('is_approved', true)
                    ->latest(),
            ])
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        $post = $this->contentService->transformBlogPost($postModel, $locale);

        return view('guest.pages.blog-detail', array_merge(
            $this->contentService->sharedData(),
            [
                'post' => $post,
                'comments' => $postModel->comments,
            ]
        ));
    }

    /**
     * Handle blog comment submission for a public post.

     *

     * @param StorePostCommentRequest $request Parameter.

     * @param  string  $slug  Parameter.
     */
    public function storeBlogComment(StorePostCommentRequest $request, string $slug): RedirectResponse|JsonResponse
    {
        $post = Post::query()
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        $comment = $post->comments()->create($request->validated());
        $this->notifyAdmins(new NewBlogCommentNotification($comment));

        if ($request->expectsJson()) {
            return response()->json([
                'message' => __('site.blog.comments.success'),
                'comment' => [
                    'name' => $comment->name,
                    'content' => $comment->content,
                    'created_at' => $comment->created_at?->format('d M, Y'),
                ],
            ]);
        }

        return redirect()
            ->route('blog.show', $slug)
            ->with('comment_success', __('site.blog.comments.success'));
    }

    /**
     * Render the public contact page.
     */
    public function contact(): View
    {
        $contactPage = $this->contentService->getContactPageData(app()->getLocale());

        return view('guest.pages.contact', array_merge(
            $this->contentService->sharedData(),
            ['contactPage' => $contactPage]
        ));
    }

    /**
     * Handle contact form submission from the public site.

     *

     * @param Request $request Parameter.

     * @return mixed
     */
    public function submitContact(Request $request)
    {
        $data = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'number' => ['nullable', 'string', 'max:255'],
            'message' => ['nullable', 'string'],
        ]);

        $submission = ContactSubmission::query()->create([
            ...$data,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
        $this->notifyAdmins(new NewContactSubmissionNotification($submission));

        return response(__('site.contact.success'), 200)
            ->header('Content-Type', 'text/plain');
    }

    private function notifyAdmins(BaseNotification $notification): void
    {
        $adminUsers = User::query()
            ->whereHas('roles', fn (Builder $query) => $query->where('name', 'admin'))
            ->get();

        if ($adminUsers->isEmpty()) {
            return;
        }

        NotificationFacade::send($adminUsers, $notification);
    }
}
