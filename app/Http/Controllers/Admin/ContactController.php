<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ContentKey;
use App\Enums\Section;
use App\Http\Controllers\Controller;
use App\Models\SectionContent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Handles HTTP endpoints for Contact Controller.
 */
class ContactController extends Controller
{
    /**
     * Display a listing for the resource.
     *
     * @return mixed
     */
    public function index()
    {
        $fields = [
            ContentKey::CONTACT_TITLE->value,
            ContentKey::CONTACT_FORM_TEXT->value,
            ContentKey::MAP_EMBED->value,
        ];
        $contents = SectionContent::where('section', Section::CONTACT)->whereIn('key', $fields)->get()->keyBy(fn ($item) => $item->language.'_'.$item->key);
        $data = [];
        foreach ($fields as $field) {
            $data[$field] = $contents->get('fr_'.$field)?->value ?? '';
            $data['en'][$field] = $contents->get('en_'.$field)?->value ?? '';
        }
        $imageKeys = [
            ContentKey::CONTACT_IMAGE->value,
        ];
        $imageContents = SectionContent::where('section', Section::CONTACT)->whereIn('key', $imageKeys)->get()->keyBy('key');
        $images = [];
        foreach ($imageKeys as $key) {
            $images[$key] = $imageContents->get($key)?->value ?? null;
        }

        return view('admin.pages.contact', compact('data', 'images'));
    }

    /**
     * Handle image upload and return the stored media path.

     *

     * @param  Request  $request  Parameter.
     */
    public function uploadImage(Request $request): JsonResponse
    {
        $request->validate(['image' => 'required|image|max:10240', 'key' => 'required|string']);
        $path = $request->file('image')->store('contact', 'public');

        return response()->json(['path' => $path, 'url' => Storage::disk('public')->url($path)]);
    }

    /**
     * Persist updates to the resource.

     *

     * @param  Request  $request  Parameter.
     */
    public function update(Request $request): RedirectResponse
    {
        $fields = [
            ContentKey::CONTACT_TITLE->value,
            ContentKey::CONTACT_FORM_TEXT->value,
            ContentKey::MAP_EMBED->value,
        ];
        $imageKeys = [
            ContentKey::CONTACT_IMAGE->value,
        ];
        foreach ($fields as $field) {
            $value = $request->input($field);
            if ($value) {
                SectionContent::updateOrCreate(['section' => Section::CONTACT, 'key' => $field, 'language' => 'fr'], ['value' => $value]);
            }
            $enValue = $request->input("en.$field");
            if ($enValue) {
                SectionContent::updateOrCreate(['section' => Section::CONTACT, 'key' => $field, 'language' => 'en'], ['value' => $enValue]);
            }
        }
        foreach ($imageKeys as $image) {
            $path = $request->input($image);
            if ($path) {
                SectionContent::updateOrCreate(['section' => Section::CONTACT, 'key' => $image], ['value' => $path, 'language' => 'fr']);
            }
        }

        return redirect()->route('admin.pages.contact')->with('status', __('admin.common.saved_successfully'));
    }
}
