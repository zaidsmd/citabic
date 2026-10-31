<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Certification;
use App\Models\CitabicDomain;
use App\Models\CitabicProfile;
use App\Models\CitabicReference;
use App\Models\CitabicValue;
use App\Models\ContactSubmission;
use App\Models\Mission;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

/**
 * Handles HTTP endpoints for Cms Controller.
 */
class CmsController extends Controller
{
    /**
     * Dashboard.
     */
    public function dashboard(): View
    {
        return view('admin.dashboard.index', [
            'stats' => [
                'posts_total' => Post::query()->count(),
                'posts_published' => Post::query()->published()->count(),
                'references_total' => CitabicReference::query()->count(),
                'domains_total' => CitabicDomain::query()->count(),
                'missions_total' => Mission::query()->count(),
                'values_total' => CitabicValue::query()->count(),
                'certifications_total' => Certification::query()->count(),
                'categories_total' => Category::query()->count(),
                'tags_total' => Tag::query()->count(),
                'comments_total' => PostComment::query()->count(),
                'pending_comments' => PostComment::query()->where('is_approved', false)->count(),
                'contact_submissions_total' => ContactSubmission::query()->count(),
                'contact_submissions_today' => ContactSubmission::query()
                    ->whereDate('created_at', now()->toDateString())
                    ->count(),
            ],
            'recentComments' => PostComment::query()
                ->with('post:id,title')
                ->latest()
                ->limit(6)
                ->get(),
            'recentContacts' => ContactSubmission::query()
                ->latest()
                ->limit(6)
                ->get(),
            'profile' => CitabicProfile::query()->first(),
        ]);
    }

    /**
     * Edit profile.
     */
    public function editProfile(): View
    {
        $profile = CitabicProfile::query()->firstOrFail();

        return view('admin.cms.profile-edit', [
            'profile' => $profile,
            'form' => $this->profileFormData($profile),
        ]);
    }

    /**
     * Update profile.

     *

     * @param  Request  $request  Parameter.
     */
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
        $ar_data = $request->input('ar', []);

        $infosData = [];
        foreach ($infoTypes as $type) {
            $infosData[$type] = [
                'fr' => $this->parseLines($request->input($type)),
                'en' => $this->parseLines($en_data[$type] ?? ''),
                'ar' => $this->parseLines($ar_data[$type] ?? ''),
            ];
        }

        $profile->update($payload);

        // Sync infos
        $profile->infos()->delete();
        foreach ($infoTypes as $type) {
            $frItems = $infosData[$type]['fr'];
            $enItems = $infosData[$type]['en'];
            $arItems = $infosData[$type]['ar'];

            $maxItems = max(count($frItems), count($enItems), count($arItems));

            for ($i = 0; $i < $maxItems; $i++) {
                $profile->infos()->create([
                    'type' => $type,
                    'content' => $frItems[$i] ?? '',
                    'sort_order' => $i,
                    'translations' => [
                        'en' => $enItems[$i] ?? '',
                        'ar' => $arItems[$i] ?? '',
                    ],
                ]);
            }
        }

        return redirect()
            ->route('admin.profile.edit')
            ->with('status', 'Profile content updated successfully.');
    }

    /**
     * Render the public references listing.

     *

     * @param Request $request Parameter.

     * @return mixed
     */
    public function references(Request $request)
    {
        if ($request->ajax()) {
            $query = CitabicReference::query();

            $table = datatables()->of($query)
                ->addColumn('image_preview', function (CitabicReference $row) {
                    $data = collect($row->blocks);
                    $heroImage = $data->where('type', 'heroImage')->first() ? $data->where('type', 'heroImage')->first()['content'] : null;
                    if (! $heroImage) {
                        return '<span class="text-muted">No image</span>';
                    }

                    $url = Storage::disk('public')->url(str_replace('storage', '', $heroImage));

                    return '<img src="'.e($url).'" alt="'.e($row->title).'" class="rounded" style="height:50px; width:50px; object-fit:cover;">';
                })
                ->addColumn('actions', function ($row) {
                    $editButton = sprintf(
                        '<a href="%s"
   class="btn btn-sm btn-light-primary me-1"
   data-bs-toggle="tooltip"
   data-bs-placement="top"
   title="'.__('admin.common.edit').'"
   aria-label="'.__('admin.common.edit').'">
    <i class="fa fa-pen"></i>
</a>',
                        route('admin.references.edit', $row->id)
                    );

                    $deleteForm = sprintf(
                        '<button data-table-action="delete"  data-href="%s"
   class="btn btn-sm btn-light-danger"
   data-bs-toggle="tooltip"
   data-bs-placement="top"
   title="'.__('admin.common.delete').'"
   aria-label="'.__('admin.common.delete').'">
    <i class="fa fa-trash-alt"></i>
</button>',
                        route('admin.references.destroy', $row->id)
                    );
                    $showButton = sprintf('<a href="%s" class="btn btn-sm btn-light-secondary me-1" target="_blank">
<i class="fa fa-eye"></i>
</a>', route('references.show', $row->slug));

                    return $showButton.$editButton.$deleteForm;
                })
                ->rawColumns(['image_preview', 'actions']);

            return $table->make(true);
        }

        return view('admin.references.references-index', [
            'references' => CitabicReference::query()->orderBy('sort_order')->get(),
        ]);
    }

    /**
     * Create reference.
     */
    public function createReference(): View
    {
        return view('admin.references.reference-form', [
            'reference' => null,
            'form' => $this->referenceFormData(),
        ]);
    }

    /**
     * Store reference.

     *

     * @param  Request  $request  Parameter.
     */
    public function storeReference(Request $request): RedirectResponse
    {
        $reference = CitabicReference::query()->create($this->buildReferencePayload($request));

        return redirect()
            ->route('admin.references.edit', $reference)
            ->with('status', 'Reference created successfully.');
    }

    /**
     * Edit reference.

     *

     * @param  CitabicReference  $reference  Parameter.
     */
    public function editReference(CitabicReference $reference): View
    {
        return view('admin.references.reference-form', [
            'reference' => $reference,
            'form' => $this->referenceFormData($reference),
        ]);
    }

    /**
     * Update reference.

     *

     * @param Request $request Parameter.

     * @param  CitabicReference  $reference  Parameter.
     */
    public function updateReference(Request $request, CitabicReference $reference): RedirectResponse
    {
        $reference->update($this->buildReferencePayload($request, $reference));

        return redirect()
            ->route('admin.references.edit', $reference)
            ->with('status', 'Reference updated successfully.');
    }

    /**
     * Destroy reference.

     *

     * @param  CitabicReference  $reference  Parameter.
     */
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
            'ar' => ['nullable', 'array'],
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
            'translations' => [
                'en' => $validated['en'] ?? [],
                'ar' => $validated['ar'] ?? [],
            ],
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
            'ar' => ['nullable', 'array'],
        ]);

        $en_data = $validated['en'] ?? [];
        if (isset($en_data['items'])) {
            $en_data['items'] = $this->parseLines($en_data['items']);
        }

        $ar_data = $validated['ar'] ?? [];
        if (isset($ar_data['items'])) {
            $ar_data['items'] = $this->parseLines($ar_data['items']);
        }

        $blocks = json_decode($validated['blocks'] ?? '[]', true);
        if (! is_array($blocks)) {
            $blocks = [];
        }

        $translations = $reference?->translations ?? [];
        $translations['en'] = $en_data;
        $translations['ar'] = $ar_data;

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
            'translations' => $translations,
        ];
    }

    private function profileFormData(CitabicProfile $profile): array
    {
        $en = $profile->translations['en'] ?? [];
        $ar = $profile->translations['ar'] ?? [];

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
            'ar' => [
                'tagline' => $ar['company']['tagline'] ?? ($ar['tagline'] ?? ''),
                'information_system' => $ar['information_system'] ?? '',
            ],
        ];

        foreach ($infoFields as $field) {
            $formData[$field] = $this->joinLines($profile->getInfo($field)->pluck('content')->all());

            $enItems = $profile->getInfo($field)->map(fn ($info) => $info->translations['en'] ?? '')->filter()->all();
            if (! empty($enItems)) {
                $formData['en'][$field] = $this->joinLines($enItems);
            } else {
                $enValue = $en[$field] ?? '';
                if (is_array($enValue)) {
                    $enValue = $this->joinLines($enValue);
                }
                $formData['en'][$field] = $enValue;
            }

            $arItems = $profile->getInfo($field)->map(fn ($info) => $info->translations['ar'] ?? '')->filter()->all();
            if (! empty($arItems)) {
                $formData['ar'][$field] = $this->joinLines($arItems);
            } else {
                $arValue = $ar[$field] ?? '';
                if (is_array($arValue)) {
                    $arValue = $this->joinLines($arValue);
                }
                $formData['ar'][$field] = $arValue;
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

        $ar = $reference?->translations['ar'] ?? [];
        if (isset($ar['items']) && is_array($ar['items'])) {
            $ar['items'] = $this->joinLines($ar['items']);
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
            'ar' => $ar,
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

        if (! is_array($decoded)) {
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
