<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CitabicFigure;
use App\Models\CitabicProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FigureController extends Controller
{
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

    public function create(): View
    {
        return view('admin.figures.form', [
            'figure' => new CitabicFigure,
            'form' => $this->formData(null),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $profile = CitabicProfile::query()->firstOrFail();

        $data = $request->validate([
            'label' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'en' => 'nullable|array',
        ]);

        $data['sort_order'] = CitabicFigure::query()->max('sort_order') + 1;
        $data['translations'] = ['en' => $data['en'] ?? []];
        unset($data['en']);

        $profile->figures()->create($data);

        return redirect()->route('admin.figures.index')->with('status', 'Figure created successfully.');
    }

    public function edit(CitabicFigure $figure): View
    {
        return view('admin.figures.form', [
            'figure' => $figure,
            'form' => $this->formData($figure),
        ]);
    }

    public function update(Request $request, CitabicFigure $figure): RedirectResponse
    {
        $data = $request->validate([
            'label' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'en' => 'nullable|array',
        ]);

        $data['translations'] = ['en' => $data['en'] ?? []];
        unset($data['en']);

        $figure->update($data);

        return redirect()->route('admin.figures.index')->with('status', 'Figure updated successfully.');
    }

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
        ];
    }
}
