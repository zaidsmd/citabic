<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CitabicProcess;
use App\Models\CitabicProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProcessController extends Controller
{
    public function index(): View
    {
        $processes = CitabicProcess::orderBy('sort_order')->get();
        return view('admin.cms.processes.index', compact('processes'));
    }

    public function create(): View
    {
        return view('admin.cms.processes.form', [
            'process' => new CitabicProcess(),
            'form' => $this->formData(null)
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $profile = CitabicProfile::query()->firstOrFail();

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'sort_order' => 'required|integer',
            'en' => 'nullable|array',
        ]);

        $data['translations'] = ['en' => $data['en'] ?? []];
        unset($data['en']);

        $profile->processes()->create($data);

        return redirect()->route('admin.processes.index')->with('status', 'Process created successfully.');
    }

    public function edit(CitabicProcess $process): View
    {
        return view('admin.cms.processes.form', [
            'process' => $process,
            'form' => $this->formData($process)
        ]);
    }

    public function update(Request $request, CitabicProcess $process): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'sort_order' => 'required|integer',
            'en' => 'nullable|array',
        ]);

        $data['translations'] = ['en' => $data['en'] ?? []];
        unset($data['en']);

        $process->update($data);

        return redirect()->route('admin.processes.index')->with('status', 'Process updated successfully.');
    }

    public function destroy(CitabicProcess $process): RedirectResponse
    {
        $process->delete();
        return redirect()->route('admin.processes.index')->with('status', 'Process deleted successfully.');
    }

    private function formData(?CitabicProcess $process): array
    {
        return [
            'title' => old('title', $process?->title),
            'description' => old('description', $process?->description),
            'sort_order' => old('sort_order', $process?->sort_order ?? 0),
            'en' => old('en', $process?->translations['en'] ?? []),
        ];
    }
}
