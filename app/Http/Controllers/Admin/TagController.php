<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TagController extends Controller
{
    public function index(): View
    {
        $tags = Tag::withCount('posts')->orderBy('name')->get();

        return view('admin.cms.tags.index', compact('tags'));
    }

    public function create(): View
    {
        return view('admin.cms.tags.form', [
            'tag' => new Tag,
        ]);
    }

    public function store(StoreTagRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);

        Tag::create($data);

        return redirect()->route('admin.tags.index')->with('status', 'Tag created successfully.');
    }

    public function edit(Tag $tag): View
    {
        return view('admin.cms.tags.form', [
            'tag' => $tag,
        ]);
    }

    public function update(UpdateTagRequest $request, Tag $tag): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);

        $tag->update($data);

        return redirect()->route('admin.tags.index')->with('status', 'Tag updated successfully.');
    }

    public function destroy(Tag $tag): RedirectResponse
    {
        $tag->delete();

        return redirect()->route('admin.tags.index')->with('status', 'Tag deleted successfully.');
    }
}
