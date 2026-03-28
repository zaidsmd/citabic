<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ImageUploadService;
use App\Services\SectionContentPageService;
use App\Services\VideoUploadService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Handles HTTP endpoints for Section Content Controller.
 */
class SectionContentController extends Controller
{
    /**
     * Create a new instance with injected dependencies.
     *
     * @param  SectionContentPageService  $sectionContentPageService  Parameter.
     * @return mixed
     */
    public function __construct(
        protected SectionContentPageService $sectionContentPageService
    ) {}

    /**
     * Display a listing for the resource.
     */
    public function index(): View
    {
        return view('admin.pages.index', $this->sectionContentPageService->getIndexData());
    }

    /**
     * Handle image upload and return the stored media path.

     *

     * @param Request $request Parameter.

     * @param  ImageUploadService  $imageService  Parameter.
     */
    public function uploadImage(Request $request, ImageUploadService $imageService): JsonResponse
    {
        $request->validate(['image' => 'required|image|max:10240', 'key' => 'required|string']);
        $path = $imageService->store($request->file('image'), 'about');

        return response()->json(['path' => $path, 'url' => Storage::disk('public')->url($path)]);
    }

    /**
     * Handle video upload and return the stored media path.

     *

     * @param Request $request Parameter.

     * @param  VideoUploadService  $videoService  Parameter.
     */
    public function uploadVideo(Request $request, VideoUploadService $videoService): JsonResponse
    {
        $request->validate(['video' => 'required|file|mimetypes:video/mp4,video/webm,video/ogg|max:102400']);
        $path = $videoService->store($request->file('video'), 'hero');

        return response()->json(['path' => $path, 'url' => Storage::disk('public')->url($path)]);
    }

    /**
     * Persist updates to the resource.

     *

     * @param  Request  $request  Parameter.
     */
    public function update(Request $request): RedirectResponse
    {
        $this->sectionContentPageService->update($request);

        return redirect()->route('admin.sections.index')->with('status', __('admin.common.saved'));
    }
}
