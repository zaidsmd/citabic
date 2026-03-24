<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CitabicDomain;
use App\Models\CitabicProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Services\ImageUploadService;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DomainController extends Controller
{
    public function index(): View
    {
        $domains = CitabicDomain::orderBy('sort_order')->get();
        return view('admin.cms.domains.index', compact('domains'));
    }

    public function create(): View
    {
        return view('admin.cms.domains.form', [
            'domain' => new CitabicDomain(),
            'form' => $this->formData(null)
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $profile = CitabicProfile::query()->firstOrFail();

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string|max:2048',
            'items' => 'nullable|array',
            'items.*' => 'nullable|string|max:255',
            'sort_order' => 'required|integer',
            'en' => 'nullable|array',
        ]);

        $data['items'] = collect($data['items'] ?? [])->map(fn($v) => trim($v))->filter()->values()->all();

        $en_data = $data['en'] ?? [];
        if (isset($en_data['items'])) {
            $en_data['items'] = collect($en_data['items'])->map(fn($v) => trim($v))->filter()->values()->all();
        }
        $data['translations'] = ['en' => $en_data];
        unset($data['en']);

        $profile->domains()->create($data);

        return redirect()->route('admin.domains.index')->with('status', 'Domain created successfully.');
    }

    public function edit(CitabicDomain $domain): View
    {
        return view('admin.cms.domains.form', [
            'domain' => $domain,
            'form' => $this->formData($domain)
        ]);
    }

    public function update(Request $request, CitabicDomain $domain): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string|max:2048',
            'items' => 'nullable|array',
            'items.*' => 'nullable|string|max:255',
            'sort_order' => 'required|integer',
            'en' => 'nullable|array',
        ]);

        $data['items'] = collect($data['items'] ?? [])->map(fn($v) => trim($v))->filter()->values()->all();

        $en_data = $data['en'] ?? [];
        if (isset($en_data['items'])) {
            $en_data['items'] = collect($en_data['items'])->map(fn($v) => trim($v))->filter()->values()->all();
        }
        $data['translations'] = ['en' => $en_data];
        unset($data['en']);

        $domain->update($data);

        return redirect()->route('admin.domains.index')->with('status', 'Domain updated successfully.');
    }

    public function uploadImage(Request $request, ImageUploadService $imageService): JsonResponse
    {
        $request->validate(['image' => 'required|image|max:10240']);
        $path = $imageService->store($request->file('image'), 'domains');
        return response()->json(['path' => $path, 'url' => Storage::disk('public')->url($path)]);
    }

    public function destroy(CitabicDomain $domain): RedirectResponse
    {
        $domain->delete();
        return redirect()->route('admin.domains.index')->with('status', 'Domain deleted successfully.');
    }

    private function formData(?CitabicDomain $domain): array
    {
        $en = $domain?->translations['en'] ?? [];

        return [
            'title' => old('title', $domain?->title),
            'icon' => old('icon', $domain?->icon),
            'items' => old('items', $domain?->items ?? []),
            'sort_order' => old('sort_order', $domain?->sort_order ?? 0),
            'en' => old('en', $en),
        ];
    }

}
