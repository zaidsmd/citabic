<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CitabicDomain;
use App\Models\CitabicProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
            'items_raw' => 'required|string',
            'sort_order' => 'required|integer',
            'en' => 'nullable|array',
        ]);

        $data['items'] = $this->parseLines($data['items_raw']);

        $en_data = $data['en'] ?? [];
        if (isset($en_data['items_raw'])) {
            $en_data['items'] = $this->parseLines($en_data['items_raw']);
            unset($en_data['items_raw']);
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
            'items_raw' => 'required|string',
            'sort_order' => 'required|integer',
            'en' => 'nullable|array',
        ]);

        $data['items'] = $this->parseLines($data['items_raw']);

        $en_data = $data['en'] ?? [];
        if (isset($en_data['items_raw'])) {
            $en_data['items'] = $this->parseLines($en_data['items_raw']);
            unset($en_data['items_raw']);
        }
        $data['translations'] = ['en' => $en_data];
        unset($data['en']);

        $domain->update($data);

        return redirect()->route('admin.domains.index')->with('status', 'Domain updated successfully.');
    }

    public function destroy(CitabicDomain $domain): RedirectResponse
    {
        $domain->delete();
        return redirect()->route('admin.domains.index')->with('status', 'Domain deleted successfully.');
    }

    private function formData(?CitabicDomain $domain): array
    {
        $en = $domain?->translations['en'] ?? [];
        if (isset($en['items']) && is_array($en['items'])) {
            $en['items_raw'] = implode(PHP_EOL, $en['items']);
        } else {
            $en['items_raw'] = '';
        }

        return [
            'title' => old('title', $domain?->title),
            'items' => old('items', $domain?->items ?? []),
            'sort_order' => old('sort_order', $domain?->sort_order ?? 0),
            'en' => old('en', $en),
        ];
    }

    private function parseLines(?string $value): array
    {
        if ($value === null || trim($value) === '') {
            return [];
        }

        return collect(preg_split('/\r\n|\r|\n/', $value))
            ->map(fn (string $line) => trim($line))
            ->filter()
            ->values()
            ->all();
    }
}
