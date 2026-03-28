<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Provides domain logic for Video Upload Service.
 */
class VideoUploadService
{
    /**
     * Persist a newly created resource.
     *
     * @param  UploadedFile  $file  Parameter.
     * @param  string  $folder  Parameter.
     */
    public function store(UploadedFile $file, string $folder): string
    {
        $extension = $file->getClientOriginalExtension() ?: $file->guessExtension();
        $filename = Str::uuid().'.'.$extension;
        $path = $folder.'/'.$filename;

        Storage::disk('public')->putFileAs($folder, $file, $filename);

        return $path;
    }
}
