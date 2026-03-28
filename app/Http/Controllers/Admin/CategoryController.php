<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Handles HTTP endpoints for Category Controller.
 */
class CategoryController extends Controller
{
    /**
     * Display a listing for the resource.
     *
     * @param  Request  $request  Parameter.
     */
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $query = Category::query()->withCount('posts');

            $table = datatables()->of($query)
                ->addColumn('actions', function (Category $category): View {
                    $actions = [
                        [
                            'type' => 'link',
                            'classNames' => 'btn-sm btn-light-primary',
                            'icon' => 'fa fa-pen',
                            'link' => route('admin.categories.edit', $category),
                            'attributes' => [
                                'data-bs-toggle' => 'tooltip',
                                'data-bs-placement' => 'top',
                                'title' => __('admin.common.edit'),
                                'aria-label' => __('admin.common.edit'),
                            ],
                        ],
                        [
                            'type' => 'destroy',
                            'link' => route('admin.categories.destroy', $category),
                        ],
                    ];

                    return view('admin.layouts.data-table-actions', compact('actions'));
                })
                ->rawColumns(['actions']);

            return $table->make(true);
        }

        return view('admin.categories.index');
    }

    /**
     * Show the creation form for the resource.
     */
    public function create(): View
    {
        return view('admin.categories.form', [
            'category' => new Category,
        ]);
    }

    /**
     * Persist a newly created resource.

     *

     * @param  StoreCategoryRequest  $request  Parameter.
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('status', 'Category created successfully.');
    }

    /**
     * Show the edit form for the resource.

     *

     * @param  Category  $category  Parameter.
     */
    public function edit(Category $category): View
    {
        return view('admin.categories.form', [
            'category' => $category,
        ]);
    }

    /**
     * Persist updates to the resource.

     *

     * @param UpdateCategoryRequest $request Parameter.

     * @param  Category  $category  Parameter.
     */
    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('status', 'Category updated successfully.');
    }

    /**
     * Delete the specified resource.

     *

     * @param  Category  $category  Parameter.
     */
    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('status', 'Category deleted successfully.');
    }
}
