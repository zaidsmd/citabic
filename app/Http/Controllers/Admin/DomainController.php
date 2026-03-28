<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CitabicDomain;
use App\Models\CitabicProfile;
use App\Services\ImageUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DomainController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $query = CitabicDomain::query();

            $table = datatables()->of($query)
                ->addColumn('items_count', function (CitabicDomain $domain): int {
                    return is_array($domain->items) ? count($domain->items) : 0;
                })
                ->addColumn('actions', function (CitabicDomain $domain): View {
                    $actions = [
                        [
                            'type' => 'link',
                            'classNames' => 'btn-sm btn-light-primary',
                            'icon' => 'fa fa-pen',
                            'link' => route('admin.domains.edit', $domain),
                            'attributes' => [
                                'data-bs-toggle' => 'tooltip',
                                'data-bs-placement' => 'top',
                                'title' => __('admin.common.edit'),
                                'aria-label' => __('admin.common.edit'),
                            ],
                        ],
                        [
                            'type' => 'destroy',
                            'link' => route('admin.domains.destroy', $domain),
                        ],
                    ];

                    return view('admin.layouts.data-table-actions', compact('actions'));
                })
                ->rawColumns(['actions']);

            return $table->make(true);
        }

        return view('admin.domains.index');
    }

    public function create(): View
    {
        return view('admin.domains.form', [
            'domain' => new CitabicDomain,
            'form' => $this->formData(null),
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
            'en' => 'nullable|array',
        ]);

        $data['items'] = collect($data['items'] ?? [])->map(fn ($v) => trim($v))->filter()->values()->all();

        $en_data = $data['en'] ?? [];
        if (isset($en_data['items'])) {
            $en_data['items'] = collect($en_data['items'])->map(fn ($v) => trim($v))->filter()->values()->all();
        }
        $data['translations'] = ['en' => $en_data];
        unset($data['en']);

        $profile->domains()->create($data);

        return redirect()->route('admin.domains.index')->with('status', 'Domain created successfully.');
    }

    public function edit(CitabicDomain $domain): View
    {
        return view('admin.domains.form', [
            'domain' => $domain,
            'form' => $this->formData($domain),
        ]);
    }

    public function update(Request $request, CitabicDomain $domain): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string|max:2048',
            'items' => 'nullable|array',
            'items.*' => 'nullable|string|max:255',
            'en' => 'nullable|array',
        ]);

        $data['items'] = collect($data['items'] ?? [])->map(fn ($v) => trim($v))->filter()->values()->all();

        $en_data = $data['en'] ?? [];
        if (isset($en_data['items'])) {
            $en_data['items'] = collect($en_data['items'])->map(fn ($v) => trim($v))->filter()->values()->all();
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
            'en' => old('en', $en),
        ];
    }
}
