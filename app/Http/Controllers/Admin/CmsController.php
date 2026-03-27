<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CitabicProfile;
use App\Models\CitabicReference;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class CmsController extends Controller
{
    public function dashboard(): View
    {
        $profile = CitabicProfile::query()->first();
        $references = CitabicReference::query()->orderBy('sort_order')->get();

        return view('admin.dashboard.index', [
            'profile' => $profile,
            'references' => $references,
            'stats' => [
                'references' => $references->count(),
                'translated_references' => $references->filter(fn(CitabicReference $reference) => !empty($reference->translations))->count(),
                'profile_sections' => 9,
            ],
        ]);
    }

    public function editProfile(): View
    {
        $profile = CitabicProfile::query()->firstOrFail();

        return view('admin.cms.profile-edit', [
            'profile' => $profile,
            'form' => $this->profileFormData($profile),
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $profile = CitabicProfile::query()->firstOrFail();

        $payload = $this->buildProfilePayload($request);

        $infoTypes = [
            'intro',
            'market_context',
            'mission',
            'certifications',
            'partnerships',
            'compliance',
            'organization',
            'why_choose_us',
        ];

        $en_data = $request->input('en', []);

        $infosData = [];
        foreach ($infoTypes as $type) {
            $infosData[$type] = [
                'fr' => $this->parseLines($request->input($type)),
                'en' => $this->parseLines($en_data[$type] ?? ''),
            ];
        }

        $profile->update($payload);

        // Sync infos
        $profile->infos()->delete();
        foreach ($infoTypes as $type) {
            $frItems = $infosData[$type]['fr'];
            $enItems = $infosData[$type]['en'];

            $maxItems = max(count($frItems), count($enItems));

            for ($i = 0; $i < $maxItems; $i++) {
                $profile->infos()->create([
                    'type' => $type,
                    'content' => $frItems[$i] ?? '',
                    'sort_order' => $i,
                    'translations' => [
                        'en' => $enItems[$i] ?? '',
                    ],
                ]);
            }
        }

        return redirect()
            ->route('admin.profile.edit')
            ->with('status', 'Profile content updated successfully.');
    }

    public function references(Request $request)
    {
        if ($request->ajax()) {
            $query = CitabicReference::query();

            $table = datatables()->of($query)
                ->addColumn('image_preview', function (CitabicReference $row) {
                    $data = collect($row->blocks);
                    $heroImage = $data->where('type', 'heroImage')->first() ? $data->where('type', 'heroImage')->first()['content'] : null;
                    if (!$heroImage) {
                        return '<span class="text-muted">No image</span>';
                    }

                    $url = Storage::disk('public')->url(str_replace('storage', '', $heroImage));

                    return '<img src="' . e($url) . '" alt="' . e($row->title) . '" class="rounded" style="height:50px; width:50px; object-fit:cover;">';
                })
                ->addColumn('actions', function ($row) {
                    $editButton = sprintf(
                        '<a href="%s"
   class="btn btn-sm btn-light-primary me-1"
   data-bs-toggle="tooltip"
   data-bs-placement="top"
   title="' . __('admin.common.edit') . '"
   aria-label="' . __('admin.common.edit') . '">
    <i class="fa fa-pen"></i>
</a>',
                        route('admin.references.edit', $row->id)
                    );


                    $deleteForm = sprintf(
                        '<button data-table-action="delete"  data-href="%s"
   class="btn btn-sm btn-light-danger"
   data-bs-toggle="tooltip"
   data-bs-placement="top"
   title="' . __('admin.common.delete') . '"
   aria-label="' . __('admin.common.delete') . '">
    <i class="fa fa-trash-alt"></i>
</button>',
                        route('admin.references.destroy', $row->id)
                    );
                    $showButton = sprintf('<a href="%s" class="btn btn-sm btn-light-secondary me-1" target="_blank">
<i class="fa fa-eye"></i>
</a>', route('references.show', $row->slug));


                    return $showButton . $editButton . $deleteForm;
                })
                ->rawColumns(['image_preview', 'actions']);

            return $table->make(true);
        }
        return view('admin.references.references-index', [
            'references' => CitabicReference::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function createReference(): View
    {
        return view('admin.references.reference-form', [
            'reference' => null,
            'form' => $this->referenceFormData(),
        ]);
    }

    public function storeReference(Request $request): RedirectResponse
    {
        $reference = CitabicReference::query()->create($this->buildReferencePayload($request));

        return redirect()
            ->route('admin.references.edit', $reference)
            ->with('status', 'Reference created successfully.');
    }

    public function editReference(CitabicReference $reference): View
    {
        return view('admin.references.reference-form', [
            'reference' => $reference,
            'form' => $this->referenceFormData($reference),
        ]);
    }

    public function updateReference(Request $request, CitabicReference $reference): RedirectResponse
    {
        $reference->update($this->buildReferencePayload($request, $reference));

        return redirect()
            ->route('admin.references.edit', $reference)
            ->with('status', 'Reference updated successfully.');
    }

    public function destroyReference(CitabicReference $reference): RedirectResponse
    {
        $reference->delete();

        return redirect()
            ->route('admin.references.index')
            ->with('status', 'Reference deleted successfully.');
    }

    private function buildProfilePayload(Request $request): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'tagline' => ['required', 'string', 'max:255'],
            'full_name' => ['required', 'string', 'max:255'],
            'legal_name' => ['required', 'string', 'max:255'],
            'legal_form' => ['required', 'string', 'max:255'],
            'capital' => ['required', 'string', 'max:255'],
            'head_office' => ['required', 'string'],
            'ice' => ['required', 'string', 'max:255'],
            'company_created_at' => ['required', 'string', 'max:255'],
            'rc' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'hero_video_path' => ['nullable', 'string', 'max:2048'],
            'intro' => ['nullable', 'string'],
            'market_context' => ['nullable', 'string'],
            'mission' => ['nullable', 'string'],
            'certifications' => ['nullable', 'string'],
            'partnerships' => ['nullable', 'string'],
            'compliance' => ['nullable', 'string'],
            'organization' => ['nullable', 'string'],
            'why_choose_us' => ['nullable', 'string'],
            'information_system' => ['required', 'string'],
            'en' => ['nullable', 'array'],
        ]);

        return [
            'name' => $validated['name'],
            'tagline' => $validated['tagline'],
            'full_name' => $validated['full_name'],
            'legal_name' => $validated['legal_name'],
            'legal_form' => $validated['legal_form'],
            'capital' => $validated['capital'],
            'head_office' => $validated['head_office'],
            'ice' => $validated['ice'],
            'company_created_at' => $validated['company_created_at'],
            'rc' => $validated['rc'],
            'status' => $validated['status'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'hero_video_path' => $validated['hero_video_path'] ?: null,
            'information_system' => $validated['information_system'],
            'translations' => ['en' => $validated['en'] ?? []],
        ];
    }

    private function buildReferencePayload(Request $request, ?CitabicReference $reference = null): array
    {
        $validated = $request->validate([
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('citabic_references', 'slug')->ignore($reference?->id),
            ],
            'title' => ['required', 'string', 'max:255'],
            'client' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'string', 'max:2048'],
            'summary' => ['required', 'string'],
            'description' => ['required', 'string'],
            'surface' => ['nullable', 'string', 'max:255'],
            'budget' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'items' => ['nullable', 'string'],
            'blocks' => ['nullable', 'string'],
            'en' => ['nullable', 'array'],
        ]);

        $en_data = $validated['en'] ?? [];
        if (isset($en_data['items'])) {
            $en_data['items'] = $this->parseLines($en_data['items']);
        }

        $blocks = json_decode($validated['blocks'] ?? '[]', true);
        if (!is_array($blocks)) {
            $blocks = [];
        }

        return [
            'slug' => $validated['slug'],
            'title' => $validated['title'],
            'client' => $validated['client'],
            'image' => $validated['image'] ?: null,
            'summary' => $validated['summary'],
            'description' => $validated['description'],
            'surface' => $validated['surface'] ?: null,
            'budget' => $validated['budget'] ?: null,
            'sort_order' => $validated['sort_order'],
            'items' => $this->parseLines($validated['items'] ?? null),
            'blocks' => $blocks,
            'translations' => ['en' => $en_data],
        ];
    }

    private function profileFormData(CitabicProfile $profile): array
    {
        $en = $profile->translations['en'] ?? [];

        // For info fields, we need to join them into strings
        $infoFields = [
            'intro', 'market_context', 'mission', 'certifications',
            'partnerships', 'compliance', 'organization', 'why_choose_us',
        ];

        $formData = [
            'name' => $profile->name,
            'tagline' => $profile->tagline,
            'full_name' => $profile->full_name,
            'legal_name' => $profile->legal_name,
            'legal_form' => $profile->legal_form,
            'capital' => $profile->capital,
            'head_office' => $profile->head_office,
            'ice' => $profile->ice,
            'company_created_at' => $profile->company_created_at,
            'rc' => $profile->rc,
            'status' => $profile->status,
            'phone' => $profile->phone,
            'email' => $profile->email,
            'hero_video_path' => $profile->hero_video_path,
            'information_system' => $profile->information_system,
            'en' => [
                'tagline' => $en['company']['tagline'] ?? ($en['tagline'] ?? ''),
                'information_system' => $en['information_system'] ?? '',
            ],
        ];

        foreach ($infoFields as $field) {
            $formData[$field] = $this->joinLines($profile->getInfo($field)->pluck('content')->all());

            // Handle English translations for info fields
            // Try to get from the new relationship-based structure first
            $enItems = $profile->getInfo($field)->map(fn($info) => $info->translations['en'] ?? '')->filter()->all();

            if (!empty($enItems)) {
                $formData['en'][$field] = $this->joinLines($enItems);
            } else {
                // Fallback to the old JSON structure in CitabicProfile (during transition)
                $enValue = $en[$field] ?? '';
                if (is_array($enValue)) {
                    $enValue = $this->joinLines($enValue);
                }
                $formData['en'][$field] = $enValue;
            }
        }

        return $formData;
    }

    private function referenceFormData(?CitabicReference $reference = null): array
    {
        $en = $reference?->translations['en'] ?? [];
        if (isset($en['items']) && is_array($en['items'])) {
            $en['items'] = $this->joinLines($en['items']);
        }

        return [
            'slug' => $reference?->slug ?? '',
            'title' => $reference?->title ?? '',
            'client' => $reference?->client ?? '',
            'image' => $reference?->image ?? '',
            'summary' => $reference?->summary ?? '',
            'description' => $reference?->description ?? '',
            'surface' => $reference?->surface ?? '',
            'budget' => $reference?->budget ?? '',
            'sort_order' => $reference?->sort_order ?? (CitabicReference::query()->max('sort_order') + 1),
            'items' => $this->joinLines($reference?->items ?? []),
            'blocks' => $reference?->blocks ?? [],
            'en' => $en,
        ];
    }

    private function parseLines(?string $value): array
    {
        if ($value === null || trim($value) === '') {
            return [];
        }

        return collect(preg_split('/\r\n|\r|\n/', $value))
            ->map(fn(string $line) => trim($line))
            ->filter()
            ->values()
            ->all();
    }

    private function joinLines(array $items): string
    {
        return implode(PHP_EOL, $items);
    }

    private function parseJsonField(string $value, string $field): array
    {
        $trimmed = trim($value);

        if ($trimmed === '') {
            return [];
        }

        try {
            $decoded = json_decode($trimmed, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $exception) {
            throw ValidationException::withMessages([
                $field => "Invalid JSON for {$field}: {$exception->getMessage()}",
            ]);
        }

        if (!is_array($decoded)) {
            throw ValidationException::withMessages([
                $field => "The {$field} field must decode to a JSON object or array.",
            ]);
        }

        return $decoded;
    }

    private function prettyJson(mixed $value): string
    {
        if ($value instanceof Collection) {
            $value = $value->all();
        }

        return json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?: '';
    }
}
