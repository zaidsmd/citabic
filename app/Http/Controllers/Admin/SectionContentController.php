<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Enums\ContentKey;
use App\Enums\Section;
use App\Models\SectionContent;
use App\Services\ImageUploadService;
use App\Services\VideoUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SectionContentController extends Controller
{
    public function index()
    {
        $contents = SectionContent::all();

        $imageKeys = [
            ContentKey::ABOUT_IMAGE_1->value,
            ContentKey::ABOUT_IMAGE_2->value,
            ContentKey::ABOUT_IMAGE_3->value,
        ];
        $imageContents = SectionContent::where('section', Section::ABOUT->value)->whereIn('key', $imageKeys)->get()->keyBy('key');
        $images = [];
        foreach ($imageKeys as $key) {
            $images[$key] = $imageContents->get($key)?->value ?? null;
        }

        $heroVideo = SectionContent::where('section', Section::HERO->value)
            ->where('key', ContentKey::HERO_VIDEO->value)
            ->first()?->value;
        $whyImage = SectionContent::where('section', Section::WHY_CHOOSE_US->value)
            ->where('key', ContentKey::WHY_IMAGE->value)
            ->first()?->value;
        return view('admin.pages.index', compact('contents', 'images', 'heroVideo', 'whyImage'));
    }


    public function uploadImage(Request $request, ImageUploadService $imageService): JsonResponse
    {
        $request->validate(['image' => 'required|image|max:10240', 'key' => 'required|string']);
        $path = $imageService->store($request->file('image'), 'about');
        return response()->json(['path' => $path, 'url' => Storage::disk('public')->url($path)]);
    }


    public function uploadVideo(Request $request, VideoUploadService $videoService): JsonResponse
    {
        $request->validate(['video' => 'required|file|mimetypes:video/mp4,video/webm,video/ogg|max:102400']);
        $path = $videoService->store($request->file('video'), 'hero');
        return response()->json(['path' => $path, 'url' => Storage::disk('public')->url($path)]);
    }


    public function update(Request $request)
    {
        $locales = ['en', 'fr'];
        $textFields = [
            ContentKey::HERO_TITLE->value    => Section::HERO->value,
            ContentKey::HERO_SUBTITLE->value => Section::HERO->value,
            ContentKey::ABOUT_TITLE->value   => Section::ABOUT->value,
            ContentKey::ABOUT_TEXT->value    => Section::ABOUT->value,
            ContentKey::DOMAIN_TITLE->value        => Section::DOMAIN->value,
            ContentKey::DOMAIN_TEXT->value         => Section::DOMAIN->value,
            ContentKey::WHY_TITLE->value           => Section::WHY_CHOOSE_US->value,
            ContentKey::WHY_SUBTITLE->value        => Section::WHY_CHOOSE_US->value,
            ContentKey::WHY_TEXT->value            => Section::WHY_CHOOSE_US->value,
        ];

        foreach ($textFields as $key => $section) {
            foreach ($locales as $locale) {
                $value = $request->input($key.'.'.$locale);
                if ($value === null) continue;
                SectionContent::updateOrCreate(
                    ['section' => $section, 'key' => $key, 'language' => $locale],
                    ['value' => $value]
                );
            }
        }

        $imageFields = [
            ContentKey::ABOUT_IMAGE_1->value => Section::ABOUT->value,
            ContentKey::ABOUT_IMAGE_2->value => Section::ABOUT->value,
            ContentKey::ABOUT_IMAGE_3->value => Section::ABOUT->value,
            ContentKey::WHY_IMAGE->value     => Section::WHY_CHOOSE_US->value,
        ];
        foreach ($imageFields as $key => $section) {
            $path = $request->input($key);
            if ($path) {
                SectionContent::updateOrCreate(
                    ['section' => $section, 'key' => $key, 'language' => 'fr'],
                    ['value' => $path]
                );
            }
        }

        // Save WHY_FEATURES as JSON per locale
        foreach ($locales as $locale) {
            $features = $request->input('why_features.'.$locale, []);
            if (is_array($features)) {
                $filtered = array_values(array_filter($features, fn($f) => !empty($f['title']) || !empty($f['text'])));
                SectionContent::updateOrCreate(
                    ['section' => Section::WHY_CHOOSE_US->value, 'key' => ContentKey::WHY_FEATURES->value, 'language' => $locale],
                    ['value' => json_encode($filtered, JSON_UNESCAPED_UNICODE)]
                );
            }
        }
        $heroVideoPath = $request->input(ContentKey::HERO_VIDEO->value);
        if ($heroVideoPath) {
            SectionContent::updateOrCreate(
                ['section' => Section::HERO->value, 'key' => ContentKey::HERO_VIDEO->value, 'language' => 'fr'],
                ['value' => $heroVideoPath]
            );
        }

        return redirect()->route('admin.sections.index')->with('status', __('admin.common.saved'));
    }
}
