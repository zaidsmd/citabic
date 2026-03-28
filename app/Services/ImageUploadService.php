<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

/**
 * Provides domain logic for Image Upload Service.
 */
class ImageUploadService
{
    /**
     * Create a new instance with injected dependencies.
     *
     * @return mixed
     */
    public function __construct()
    {
        $this->manager = new ImageManager(new Driver);
    }

    /**
     * Persist a newly created resource.

     *

     * @param UploadedFile $file Parameter.

     * @param  string  $folder  Parameter.
     */
    public function store(UploadedFile $file, string $folder, ?int $maxWidth = 1920, int $quality = 82): string
    {
        $image = $this->manager->read($file->getRealPath());

        if ($maxWidth && $image->width() > $maxWidth) {
            $image->scaleDown(width: $maxWidth);
        }

        $filename = Str::uuid().'.webp';
        $path = $folder.'/'.$filename;

        Storage::disk('public')->put($path, $image->toWebp($quality));

        return $path;
    }
}
