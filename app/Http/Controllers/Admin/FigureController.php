<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CitabicFigure;
use App\Models\CitabicProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FigureController extends Controller
{
    public function index(): View
    {
        $figures = CitabicFigure::orderBy('sort_order')->get();
        return view('admin.cms.figures.index', compact('figures'));
    }

    public function create(): View
    {
        return view('admin.cms.figures.form', [
            'figure' => new CitabicFigure(),
            'form' => $this->formData(null)
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $profile = CitabicProfile::query()->firstOrFail();

        $data = $request->validate([
            'label' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'sort_order' => 'required|integer',
            'en' => 'nullable|array',
        ]);

        $data['translations'] = ['en' => $data['en'] ?? []];
        unset($data['en']);

        $profile->figures()->create($data);

        return redirect()->route('admin.figures.index')->with('status', 'Figure created successfully.');
    }

    public function edit(CitabicFigure $figure): View
    {
        return view('admin.cms.figures.form', [
            'figure' => $figure,
            'form' => $this->formData($figure)
        ]);
    }

    public function update(Request $request, CitabicFigure $figure): RedirectResponse
    {
        $data = $request->validate([
            'label' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'sort_order' => 'required|integer',
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
