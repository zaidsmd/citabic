<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateGoogleTranslateSettingsRequest;
use App\Models\AppSetting;
use Illuminate\Support\Facades\Storage;

class GoogleTranslateSettingsController extends Controller
{
    public function index()
    {
        $projectId = AppSetting::getValue('google_translate_project_id', config('services.google_translate.project_id'));
        $keyFilePath = AppSetting::getValue('google_translate_key_file_path', config('services.google_translate.key_file_path'));

        return view('admin.settings.google-translate', [
            'projectId' => $projectId,
            'keyFilePath' => $keyFilePath,
        ]);
    }

    public function update(UpdateGoogleTranslateSettingsRequest $request)
    {
        $validated = $request->validated();

        AppSetting::setValue('google_translate_project_id', $validated['project_id']);

        $storedKeyFilePath = AppSetting::getValue('google_translate_key_file_path');
        if ($request->boolean('remove_key_file') && is_string($storedKeyFilePath) && $storedKeyFilePath !== '') {
            Storage::disk('local')->delete($storedKeyFilePath);
            AppSetting::setValue('google_translate_key_file_path', null);
        }

        if ($request->hasFile('key_file')) {
            if (is_string($storedKeyFilePath) && $storedKeyFilePath !== '') {
                Storage::disk('local')->delete($storedKeyFilePath);
            }

            $path = $request->file('key_file')->store('google-translate-keys', 'local');
            AppSetting::setValue('google_translate_key_file_path', $path);
        }

        return redirect()
            ->route('admin.settings.google-translate.index')
            ->with('status', __('admin.google_translate_settings.messages.updated'));
    }
}
