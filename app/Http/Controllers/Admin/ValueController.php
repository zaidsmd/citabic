<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CitabicProfile;
use App\Models\CitabicValue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ValueController extends Controller
{
    public function index(Request $request): View
    {
        $type = $request->query('type', 'values');
        $values = CitabicValue::where('type', $type)->orderBy('sort_order')->get();
        return view('admin.cms.values.index', compact('values', 'type'));
    }

    public function create(Request $request): View
    {
        $type = $request->query('type', 'values');
        return view('admin.cms.values.form', [
            'value' => new CitabicValue(['type' => $type]),
            'type' => $type,
            'form' => $this->formData(null, $type)
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $profile = CitabicProfile::query()->firstOrFail();

        $data = $request->validate([
            'type' => 'required|in:values,human_values',
            'title' => 'required|string|max:255',
            'text' => 'required|string',
            'sort_order' => 'required|integer',
            'en' => 'nullable|array',
        ]);

        $data['translations'] = ['en' => $data['en'] ?? []];
        unset($data['en']);

        $profile->values()->create($data);

        return redirect()->route('admin.values.index', ['type' => $data['type']])
            ->with('status', 'Value created successfully.');
    }

    public function edit(CitabicValue $value): View
    {
        return view('admin.cms.values.form', [
            'value' => $value,
            'type' => $value->type,
            'form' => $this->formData($value, $value->type)
        ]);
    }

    public function update(Request $request, CitabicValue $value): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'required|string',
            'sort_order' => 'required|integer',
            'en' => 'nullable|array',
        ]);

        $data['translations'] = ['en' => $data['en'] ?? []];
        unset($data['en']);

        $value->update($data);

        return redirect()->route('admin.values.index', ['type' => $value->type])
            ->with('status', 'Value updated successfully.');
    }

    public function destroy(CitabicValue $value): RedirectResponse
    {
        $type = $value->type;
        $value->delete();
        return redirect()->route('admin.values.index', ['type' => $type])
            ->with('status', 'Value deleted successfully.');
    }

    private function formData(?CitabicValue $value, string $type): array
    {
        return [
            'type' => old('type', $value?->type ?? $type),
            'title' => old('title', $value?->title),
            'text' => old('text', $value?->text),
            'sort_order' => old('sort_order', $value?->sort_order ?? 0),
            'en' => old('en', $value?->translations['en'] ?? []),
        ];
    }
}
