<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\ImageUploadService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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
        $post = new Post(); // For the form view to use safely
        return view('admin.cms.posts.form', compact('categories', 'tags', 'post'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'status' => 'required|in:draft,published,archived',
            'featured_image' => 'nullable|string',
            'published_at' => 'nullable|date',
            'featured' => 'nullable|boolean',
            'allow_comments' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'canonical_url' => 'nullable|url',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'en' => 'nullable|array',
        ]);

        $validated['author_id'] = auth()->id() ?? 1;
        $validated['featured'] = $request->has('featured');
        $validated['allow_comments'] = $request->has('allow_comments');
        $validated['translations'] = ['en' => $request->en ?? []];

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $post = Post::create($validated);

        if ($request->has('categories')) {
            $post->categories()->sync($request->categories);
        }

        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        }

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully.');
    }

    public function show(Post $post)
    {
        if ($post->status !== 'published' && (!auth()->check())) {
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

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable', 'string', 'max:255',
                Rule::unique('posts', 'slug')->ignore($post->id)
            ],
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'status' => 'required|in:draft,published,archived',
            'featured_image' => 'nullable|string',
            'published_at' => 'nullable|date',
            'featured' => 'nullable|boolean',
            'allow_comments' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'canonical_url' => 'nullable|url',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'en' => 'nullable|array',
        ]);

        $validated['featured'] = $request->has('featured');
        $validated['allow_comments'] = $request->has('allow_comments');
        $validated['translations'] = ['en' => $request->en ?? []];

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $post->update($validated);

        $post->categories()->sync($request->categories ?? []);
        $post->tags()->sync($request->tags ?? []);

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully.');
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
}
