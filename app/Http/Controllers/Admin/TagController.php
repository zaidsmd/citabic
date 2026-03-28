<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Handles HTTP endpoints for Tag Controller.
 */
class TagController extends Controller
{
    /**
     * Display a listing for the resource.
     *
     * @param  Request  $request  Parameter.
     */
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $query = Tag::query()->withCount('posts');

            $table = datatables()->of($query)
                ->addColumn('actions', function (Tag $tag): View {
                    $actions = [
                        [
                            'type' => 'link',
                            'classNames' => 'btn-sm btn-light-primary',
                            'icon' => 'fa fa-pen',
                            'link' => route('admin.tags.edit', $tag),
                            'attributes' => [
                                'data-bs-toggle' => 'tooltip',
                                'data-bs-placement' => 'top',
                                'title' => __('admin.common.edit'),
                                'aria-label' => __('admin.common.edit'),
                            ],
                        ],
                        [
                            'type' => 'destroy',
                            'link' => route('admin.tags.destroy', $tag),
                        ],
                    ];

                    return view('admin.layouts.data-table-actions', compact('actions'));
                })
                ->rawColumns(['actions']);

            return $table->make(true);
        }

        return view('admin.tags.index');
    }

    /**
     * Show the creation form for the resource.
     */
    public function create(): View
    {
        return view('admin.tags.form', [
            'tag' => new Tag,
        ]);
    }

    /**
     * Persist a newly created resource.

     *

     * @param  StoreTagRequest  $request  Parameter.
     */
    public function store(StoreTagRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);

        Tag::create($data);

        return redirect()->route('admin.tags.index')->with('status', 'Tag created successfully.');
    }

    /**
     * Show the edit form for the resource.

     *

     * @param  Tag  $tag  Parameter.
     */
    public function edit(Tag $tag): View
    {
        return view('admin.tags.form', [
            'tag' => $tag,
        ]);
    }

    /**
     * Persist updates to the resource.

     *

     * @param UpdateTagRequest $request Parameter.

     * @param  Tag  $tag  Parameter.
     */
    public function update(UpdateTagRequest $request, Tag $tag): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);

        $tag->update($data);

        return redirect()->route('admin.tags.index')->with('status', 'Tag updated successfully.');
    }

    /**
     * Delete the specified resource.

     *

     * @param  Tag  $tag  Parameter.
     */
    public function destroy(Tag $tag): RedirectResponse
    {
        $tag->delete();

        return redirect()->route('admin.tags.index')->with('status', 'Tag deleted successfully.');
    }
}
