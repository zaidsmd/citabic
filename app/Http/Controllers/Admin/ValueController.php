<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CitabicProfile;
use App\Models\CitabicValue;
use App\Services\ImageUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Handles HTTP endpoints for Value Controller.
 */
class ValueController extends Controller
{
    /**
     * Display a listing for the resource.
     *
     * @param  Request  $request  Parameter.
     */
    public function index(Request $request): View|JsonResponse
    {
        $type = $request->query('type', 'values');

        if ($request->ajax()) {
            $query = CitabicValue::query()->where('type', $type);

            $table = datatables()->of($query)
                ->addColumn('image_preview', function (CitabicValue $value): string {
                    if (! empty($value->image)) {
                        $url = Storage::disk('public')->url($value->image);

                        return '<img src="'.e($url).'" alt="'.e($value->title).'" style="width: 72px; height: 72px; object-fit: cover;" class="rounded border">';
                    }

                    return '<span class="text-muted small">'.e(__('admin.values.no_image')).'</span>';
                })
                ->addColumn('text_excerpt', function (CitabicValue $value): string {
                    return Str::limit($value->text, 100);
                })
                ->addColumn('actions', function (CitabicValue $value): View {
                    $actions = [
                        [
                            'type' => 'link',
                            'classNames' => 'btn-sm btn-light-primary',
                            'icon' => 'fa fa-pen',
                            'link' => route('admin.values.edit', $value),
                            'attributes' => [
                                'data-bs-toggle' => 'tooltip',
                                'data-bs-placement' => 'top',
                                'title' => __('admin.common.edit'),
                                'aria-label' => __('admin.common.edit'),
                            ],
                        ],
                        [
                            'type' => 'destroy',
                            'link' => route('admin.values.destroy', $value),
                        ],
                    ];

                    return view('admin.layouts.data-table-actions', compact('actions'));
                })
                ->rawColumns(['image_preview', 'actions', 'text_excerpt']);

            return $table->make(true);
        }

        return view('admin.values.index', compact('type'));
    }

    /**
     * Show the creation form for the resource.

     *

     * @param  Request  $request  Parameter.
     */
    public function create(Request $request): View
    {
        $type = $request->query('type', 'values');

        return view('admin.values.form', [
            'value' => new CitabicValue(['type' => $type]),
            'type' => $type,
            'form' => $this->formData(null, $type),
        ]);
    }

    /**
     * Persist a newly created resource.

     *

     * @param  Request  $request  Parameter.
     */
    public function store(Request $request): RedirectResponse
    {
        $profile = CitabicProfile::query()->firstOrFail();

        $data = $request->validate([
            'type' => 'required|in:values,human_values',
            'title' => 'required|string|max:255',
            'text' => 'required|string',
            'image' => 'nullable|string|max:2048',
            'en' => 'nullable|array',
        ]);

        $data['translations'] = ['en' => $data['en'] ?? []];
        unset($data['en']);

        $profile->values()->create($data);

        return redirect()->route('admin.values.index', ['type' => $data['type']])
            ->with('status', 'Value created successfully.');
    }

    /**
     * Show the edit form for the resource.

     *

     * @param  CitabicValue  $value  Parameter.
     */
    public function edit(CitabicValue $value): View
    {
        return view('admin.values.form', [
            'value' => $value,
            'type' => $value->type,
            'form' => $this->formData($value, $value->type),
        ]);
    }

    /**
     * Persist updates to the resource.

     *

     * @param Request $request Parameter.

     * @param  CitabicValue  $value  Parameter.
     */
    public function update(Request $request, CitabicValue $value): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'required|string',
            'image' => 'nullable|string|max:2048',
            'en' => 'nullable|array',
        ]);

        $data['translations'] = ['en' => $data['en'] ?? []];
        unset($data['en']);

        $value->update($data);

        return redirect()->route('admin.values.index', ['type' => $value->type])
            ->with('status', 'Value updated successfully.');
    }

    /**
     * Delete the specified resource.

     *

     * @param  CitabicValue  $value  Parameter.
     */
    public function destroy(CitabicValue $value): RedirectResponse
    {
        $type = $value->type;
        $value->delete();

        return redirect()->route('admin.values.index', ['type' => $type])
            ->with('status', 'Value deleted successfully.');
    }

    /**
     * Handle image upload and return the stored media path.

     *

     * @param Request $request Parameter.

     * @param  ImageUploadService  $imageUploadService  Parameter.
     */
    public function uploadImage(Request $request, ImageUploadService $imageUploadService): JsonResponse
    {
        $request->validate([
            'image' => 'required|image|max:10240',
        ]);

        $path = $imageUploadService->store($request->file('image'), 'values');

        return response()->json([
            'path' => $path,
            'url' => Storage::disk('public')->url($path),
        ]);
    }

    private function formData(?CitabicValue $value, string $type): array
    {
        return [
            'type' => old('type', $value?->type ?? $type),
            'title' => old('title', $value?->title),
            'text' => old('text', $value?->text),
            'image' => old('image', $value?->image),
            'en' => old('en', $value?->translations['en'] ?? []),
        ];
    }
}
