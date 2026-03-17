<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Enums\ContentKey;
use App\Enums\Section;
use App\Models\SectionContent;
use Illuminate\Http\Request;

class SectionContentController extends Controller
{
    public function index()
    {
        $contents = SectionContent::all();
        return view('admin.sections.index',compact('contents'));
    }


    public function update(Request $request)
    {
        $locales = ['en', 'fr'];
        $fields = [
            ContentKey::HERO_TITLE->value    => Section::HERO->value,
            ContentKey::HERO_SUBTITLE->value => Section::HERO->value,
            ContentKey::ABOUT_TITLE->value   => Section::ABOUT->value,
            ContentKey::ABOUT_TEXT->value    => Section::ABOUT->value,
        ];

        foreach ($fields as $key => $section) {
            foreach ($locales as $locale) {
                $value = $request->input($key.'.'.$locale);
                if ($value === null) continue;
                SectionContent::updateOrCreate(
                    ['section' => $section, 'key' => $key, 'language' => $locale],
                    ['value' => $value]
                );
            }
        }

        return redirect()->route('admin.sections.index')->with('status', __('admin.common.saved'));
    }
}
