<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoUploadService
{
    /**
     * Store an uploaded video file as-is (preserving original format).
     *
     * @param  UploadedFile  $file
     * @param  string        $folder  Storage folder (e.g. 'hero')
     * @return string                 Stored path relative to the public disk
     */
    public function store(UploadedFile $file, string $folder): string
    {
        $extension = $file->getClientOriginalExtension() ?: $file->guessExtension();
        $filename  = Str::uuid() . '.' . $extension;
        $path      = $folder . '/' . $filename;

        Storage::disk('public')->putFileAs($folder, $file, $filename);

        return $path;
    }
}
