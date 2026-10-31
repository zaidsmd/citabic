<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use App\Models\MissionTranslation;
use App\Services\ImageUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

/**
 * Handles HTTP endpoints for Mission Controller.
 */
class MissionController extends Controller
{
    /**
     * Display a listing for the resource.
     *
     * @param  Request  $request  Parameter.
     */
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $query = Mission::query()->with('translations');

            $table = datatables()->of($query)
                ->addColumn('title_fr', function (Mission $mission): string {
                    return $mission->translations->firstWhere('locale', 'fr')?->title ?? '-';
                })
                ->addColumn('title_en', function (Mission $mission): string {
                    return $mission->translations->firstWhere('locale', 'en')?->title ?? '-';
                })
                ->addColumn('icon_preview', function (Mission $mission): string {
                    if (! $mission->icon) {
                        return '<span class="text-muted">-</span>';
                    }

                    return '<img src="'.e(Storage::disk('public')->url($mission->icon)).'" alt="icon" style="height:40px;width:40px;object-fit:cover;border-radius:4px;">';
                })
                ->addColumn('actions', function (Mission $mission): View {
                    $actions = [
                        [
                            'type' => 'link',
                            'classNames' => 'btn-sm btn-light-primary',
                            'icon' => 'fa fa-pen',
                            'link' => route('admin.missions.edit', $mission),
                            'attributes' => [
                                'data-bs-toggle' => 'tooltip',
                                'data-bs-placement' => 'top',
                                'title' => __('admin.common.edit'),
                                'aria-label' => __('admin.common.edit'),
                            ],
                        ],
                        [
                            'type' => 'destroy',
                            'link' => route('admin.missions.destroy', $mission),
                        ],
                    ];

                    return view('admin.layouts.data-table-actions', compact('actions'));
                })
                ->rawColumns(['icon_preview', 'actions']);

            return $table->make(true);
        }

        return view('admin.missions.index');
    }

    /**
     * Show the creation form for the resource.
     */
    public function create(): View
    {
        return view('admin.missions.form', [
            'mission' => new Mission,
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
        $data = $request->validate([
            'icon' => 'nullable|string|max:2048',
            'fr' => 'nullable|array',
            'fr.title' => 'nullable|string|max:255',
            'fr.description' => 'nullable|string',
            'en' => 'nullable|array',
            'en.title' => 'nullable|string|max:255',
            'en.description' => 'nullable|string',
            'ar' => 'nullable|array',
            'ar.title' => 'nullable|string|max:255',
            'ar.description' => 'nullable|string',
        ]);
        $mission = Mission::create([
            'icon' => $data['icon'] ?? null,
        ]);
        foreach (config('localization.supported', ['fr', 'en', 'ar']) as $locale) {
            MissionTranslation::create([
                'mission_id' => $mission->id,
                'locale' => $locale,
                'title' => $data[$locale]['title'] ?? '',
                'description' => $data[$locale]['description'] ?? '',
            ]);
        }

        return redirect()->route('admin.missions.index')->with('status', 'Mission created successfully.');
    }

    /**
     * Show the edit form for the resource.

     *

     * @param  Mission  $mission  Parameter.
     */
    public function edit(Mission $mission): View
    {
        return view('admin.missions.form', [
            'mission' => $mission,
            'form' => $this->formData($mission),
        ]);
    }

    /**
     * Persist updates to the resource.

     *

     * @param Request $request Parameter.

     * @param  Mission  $mission  Parameter.
     */
    public function update(Request $request, Mission $mission): RedirectResponse
    {
        $data = $request->validate([
            'icon' => 'nullable|string|max:2048',
            'fr' => 'nullable|array',
            'fr.title' => 'nullable|string|max:255',
            'fr.description' => 'nullable|string',
            'en' => 'nullable|array',
            'en.title' => 'nullable|string|max:255',
            'en.description' => 'nullable|string',
            'ar' => 'nullable|array',
            'ar.title' => 'nullable|string|max:255',
            'ar.description' => 'nullable|string',
        ]);
        $mission->update([
            'icon' => $data['icon'] ?? null,
        ]);
        foreach (config('localization.supported', ['fr', 'en', 'ar']) as $locale) {
            MissionTranslation::updateOrCreate(
                ['mission_id' => $mission->id, 'locale' => $locale],
                [
                    'title' => $data[$locale]['title'] ?? '',
                    'description' => $data[$locale]['description'] ?? '',
                ]
            );
        }

        return redirect()->route('admin.missions.index')->with('status', 'Mission updated successfully.');
    }

    /**
     * Delete the specified resource.

     *

     * @param  Mission  $mission  Parameter.
     */
    public function destroy(Mission $mission): RedirectResponse
    {
        if ($mission->icon) {
            Storage::disk('public')->delete($mission->icon);
        }
        $mission->delete();

        return redirect()->route('admin.missions.index')->with('status', 'Mission deleted successfully.');
    }

    /**
     * Handle image upload and return the stored media path.

     *

     * @param Request $request Parameter.

     * @param  ImageUploadService  $imageService  Parameter.
     */
    public function uploadImage(Request $request, ImageUploadService $imageService): JsonResponse
    {
        $request->validate(['image' => 'required|image|max:10240']);
        $path = $imageService->store($request->file('image'), 'missions');

        return response()->json([
            'path' => $path,
            'url' => Storage::disk('public')->url($path),
        ]);
    }

    private function formData(?Mission $mission): array
    {
        $fr = $mission?->translations->firstWhere('locale', 'fr');
        $en = $mission?->translations->firstWhere('locale', 'en');
        $ar = $mission?->translations->firstWhere('locale', 'ar');

        return [
            'icon' => old('icon', $mission?->icon),
            'fr' => old('fr', ['title' => $fr?->title ?? '', 'description' => $fr?->description ?? '']),
            'en' => old('en', ['title' => $en?->title ?? '', 'description' => $en?->description ?? '']),
            'ar' => old('ar', ['title' => $ar?->title ?? '', 'description' => $ar?->description ?? '']),
        ];
    }
}
