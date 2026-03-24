<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageUploadService
{
    private ImageManager $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Store an uploaded image as WebP with optional max-width resize.
     *
     * @param  UploadedFile  $file
     * @param  string        $folder   Storage folder (e.g. 'missions')
     * @param  int|null      $maxWidth Max width in pixels; null = no resize
     * @param  int           $quality  WebP quality (1-100)
     * @return string                  Stored path relative to the public disk
     */
    public function store(UploadedFile $file, string $folder, ?int $maxWidth = 1920, int $quality = 82): string
    {
        $image = $this->manager->read($file->getRealPath());

        if ($maxWidth && $image->width() > $maxWidth) {
            $image->scaleDown(width: $maxWidth);
        }

        $filename = Str::uuid() . '.webp';
        $path     = $folder . '/' . $filename;

        Storage::disk('public')->put($path, $image->toWebp($quality));

        return $path;
    }
}
