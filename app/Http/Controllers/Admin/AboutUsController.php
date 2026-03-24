<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ContentKey;
use App\Enums\Section;
use App\Http\Controllers\Controller;
use App\Models\SectionContent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Services\ImageUploadService;
use Illuminate\Support\Facades\Storage;

class AboutUsController extends Controller
{
    public function index(){
        $fields = [
            ContentKey::ABOUT_TITLE->value,
            ContentKey::ROUNDED_TEXT->value,
            ContentKey::ABOUT_TEXT->value,
            ContentKey::MISSION_TITLE->value,
            ContentKey::MISSION_TEXT->value,
            ContentKey::WHY_US_TITLE->value,
            ContentKey::WHY_US_TEXT->value,
            ContentKey::WHY_US_CARDS->value,
            ContentKey::ORGANIGRAME_TITLE->value,
            ContentKey::CARTOGRAPHIE_TITLE->value,
        ];

        $contents = SectionContent::where('section' ,Section::ABOUT_PAGE)->whereIn('key', $fields)->get()->keyBy(fn($item) => $item->language . '_' . $item->key);

        $data = [];
        foreach ($fields as $field) {
            $data[$field] = $contents->get('fr_' . $field)?->value ?? '';
            $data['en'][$field] = $contents->get('en_' . $field)?->value ?? '';
        }

        $imageKeys = [
            ContentKey::ABOUT_HEADER_BG_IMG->value,
            ContentKey::SECTION_IMAGE->value,
            ContentKey::ORGANIGRAME->value,
            ContentKey::CARTOGRAPHIE->value,
        ];
        $imageContents = SectionContent::where('section', Section::ABOUT_PAGE)->whereIn('key', $imageKeys)->get()->keyBy('key');
        $images = [];
        foreach ($imageKeys as $key) {
            $images[$key] = $imageContents->get($key)?->value ?? null;
        }

        return view('admin.pages.about-us', compact('data', 'images'));
    }


    public function uploadImage(Request $request, ImageUploadService $imageService): JsonResponse
    {
        $request->validate(['image' => 'required|image|max:10240', 'key' => 'required|string']);
        $path = $imageService->store($request->file('image'), 'about');
        return response()->json(['path' => $path, 'url' => Storage::disk('public')->url($path)]);
    }

    public function update(Request $request): RedirectResponse
    {
        $images = [
            ContentKey::ABOUT_HEADER_BG_IMG->value,
            ContentKey::SECTION_IMAGE->value,
            ContentKey::ORGANIGRAME->value,
            ContentKey::CARTOGRAPHIE->value,
        ];
        $fields = [
            ContentKey::ABOUT_TITLE->value,
            ContentKey::ROUNDED_TEXT->value,
            ContentKey::ABOUT_TEXT->value,
            ContentKey::MISSION_TITLE->value,
            ContentKey::MISSION_TEXT->value,
            ContentKey::WHY_US_TITLE->value,
            ContentKey::WHY_US_TEXT->value,
            ContentKey::WHY_US_CARDS->value,
            ContentKey::ORGANIGRAME_TITLE->value,
            ContentKey::CARTOGRAPHIE_TITLE->value,
        ];

        foreach ($fields as $field) {
            $value = $request->input($field);
            if ($value) {
                SectionContent::updateOrCreate(['section' => Section::ABOUT_PAGE, 'key' => $field, 'language' => 'fr'], ['value' => $value]);
            }
            $enValue = $request->input("en.$field");
            if ($enValue) {
                SectionContent::updateOrCreate(['section' => Section::ABOUT_PAGE, 'key' => $field, 'language' => 'en'], ['value' => $enValue]);
            }
        }

        foreach ($images as $image) {
            $path = $request->input($image);
            if ($path) {
                // If the path already starts with 'storage/', use as-is; otherwise prefix it (new upload from AJAX returns raw path)
                $storedValue = $path;
                SectionContent::updateOrCreate(['section' => Section::ABOUT_PAGE, 'key' => $image], ['value' => $storedValue, 'language' => 'fr']);
            }
        }

        return redirect()->route('admin.pages.about-us')->with('status', __('admin.common.saved_successfully'));
    }
}
