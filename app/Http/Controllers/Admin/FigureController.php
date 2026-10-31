<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CitabicFigure;
use App\Models\CitabicProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Handles HTTP endpoints for Figure Controller.
 */
class FigureController extends Controller
{
    /**
     * Display a listing for the resource.
     *
     * @param  Request  $request  Parameter.
     */
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $query = CitabicFigure::query();

            $table = datatables()->of($query)
                ->addColumn('actions', function (CitabicFigure $figure): View {
                    $actions = [
                        [
                            'type' => 'link',
                            'classNames' => 'btn-sm btn-light-primary',
                            'icon' => 'fa fa-pen',
                            'link' => route('admin.figures.edit', $figure),
                            'attributes' => [
                                'data-bs-toggle' => 'tooltip',
                                'data-bs-placement' => 'top',
                                'title' => __('admin.common.edit'),
                                'aria-label' => __('admin.common.edit'),
                            ],
                        ],
                        [
                            'type' => 'destroy',
                            'link' => route('admin.figures.destroy', $figure),
                        ],
                    ];

                    return view('admin.layouts.data-table-actions', compact('actions'));
                })
                ->rawColumns(['actions']);

            return $table->make(true);
        }

        return view('admin.figures.index');
    }

    /**
     * Show the creation form for the resource.
     */
    public function create(): View
    {
        return view('admin.figures.form', [
            'figure' => new CitabicFigure,
            'form' => $this->formData(null),
        ]);
    }

    /**
     * Persist a newly created resource.

     *

     * @param  Request  $request  Parameter.
     */
    public function store(Request $request): RedirectResponse
    {
        $profile = CitabicProfile::query()->firstOrFail();

        $data = $request->validate([
            'label' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'en' => 'nullable|array',
            'ar' => 'nullable|array',
        ]);

        $data['sort_order'] = CitabicFigure::query()->max('sort_order') + 1;
        $data['translations'] = [
            'en' => $data['en'] ?? [],
            'ar' => $data['ar'] ?? [],
        ];
        unset($data['en'], $data['ar']);

        $profile->figures()->create($data);

        return redirect()->route('admin.figures.index')->with('status', 'Figure created successfully.');
    }

    /**
     * Show the edit form for the resource.

     *

     * @param  CitabicFigure  $figure  Parameter.
     */
    public function edit(CitabicFigure $figure): View
    {
        return view('admin.figures.form', [
            'figure' => $figure,
            'form' => $this->formData($figure),
        ]);
    }

    /**
     * Persist updates to the resource.

     *

     * @param Request $request Parameter.

     * @param  CitabicFigure  $figure  Parameter.
     */
    public function update(Request $request, CitabicFigure $figure): RedirectResponse
    {
        $data = $request->validate([
            'label' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'en' => 'nullable|array',
            'ar' => 'nullable|array',
        ]);

        $translations = $figure->translations ?? [];
        $translations['en'] = $data['en'] ?? [];
        $translations['ar'] = $data['ar'] ?? [];
        $data['translations'] = $translations;
        unset($data['en'], $data['ar']);

        $figure->update($data);

        return redirect()->route('admin.figures.index')->with('status', 'Figure updated successfully.');
    }

    /**
     * Delete the specified resource.

     *

     * @param  CitabicFigure  $figure  Parameter.
     */
    public function destroy(CitabicFigure $figure): RedirectResponse
    {
        $figure->delete();

        return redirect()->route('admin.figures.index')->with('status', 'Figure deleted successfully.');
    }

    private function formData(?CitabicFigure $figure): array
    {
        return [
            'label' => old('label', $figure?->label),
            'value' => old('value', $figure?->value),
            'sort_order' => old('sort_order', $figure?->sort_order ?? 0),
            'en' => old('en', $figure?->translations['en'] ?? []),
            'ar' => old('ar', $figure?->translations['ar'] ?? []),
        ];
    }
}
