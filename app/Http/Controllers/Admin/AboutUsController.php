<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateAboutUsRequest;
use App\Services\AboutUsService;
use App\Services\ImageUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Handles HTTP endpoints for About Us Controller.
 */
class AboutUsController extends Controller
{
    /**
     * Create a new instance with injected dependencies.
     *
     * @param  AboutUsService  $aboutUsService  Parameter.
     * @return mixed
     */
    public function __construct(AboutUsService $aboutUsService)
    {
        $this->aboutUsService = $aboutUsService;
    }

    /**
     * Display a listing for the resource.

     *

     * @return mixed
     */
    public function index()
    {
        return view('admin.pages.about-us', $this->aboutUsService->getAboutData());
    }

    /**
     * Handle image upload and return the stored media path.

     *

     * @param Request $request Parameter.

     * @param  ImageUploadService  $imageService  Parameter.
     */
    public function uploadImage(Request $request, ImageUploadService $imageService): JsonResponse
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'key' => 'required|string|in:'.implode(',', array_map(fn ($field) => $field->value, $this->aboutUsService->getImageFields())),
        ]);

        try {
            $path = $imageService->store($request->file('image'), 'about');

            return response()->json([
                'success' => true,
                'path' => $path,
                'url' => Storage::disk('public')->url($path),
                'message' => __('admin.common.image_uploaded_successfully'),
            ]);
        } catch (\Exception $e) {
            \Log::error('Image upload failed: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => __('admin.common.image_upload_failed'),
            ], 500);
        }
    }

    /**
     * Persist updates to the resource.

     *

     * @param  UpdateAboutUsRequest  $request  Parameter.
     */
    public function update(UpdateAboutUsRequest $request): RedirectResponse
    {
        try {
            $this->aboutUsService->updateAboutData($request);

            return redirect()
                ->route('admin.pages.about-us')
                ->with('status', __('admin.common.saved_successfully'));
        } catch (\Exception $e) {
            \Log::error('Failed to update about us page: '.$e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('admin.common.update_failed'));
        }
    }
}
