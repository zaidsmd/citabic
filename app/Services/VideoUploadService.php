<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Provides domain logic for Video Upload and Optimization Service.
 */
class VideoUploadService
{
    public function __construct(
        protected VideoOptimizationService $optimizationService
    ) {}

    /**
     * Store and optimize an uploaded video file, returning the main video relative path.
     *
     * @param  UploadedFile  $file  The uploaded video file.
     * @param  string  $folder  Storage folder (e.g. 'hero').
     * @return string Relative storage path to the optimized MP4.
     */
    public function store(UploadedFile $file, string $folder): string
    {
        $result = $this->storeWithOptimization($file, $folder);

        return $result['path'];
    }

    /**
     * Store and optimize an uploaded video file, returning paths and URLs for streaming and posters.
     *
     * @param  UploadedFile  $file  The uploaded video file.
     * @param  string  $folder  Storage folder (e.g. 'hero').
     * @return array{
     *     path: string,
     *     url: string,
     *     stream_url: string,
     *     webm_path: ?string,
     *     webm_url: ?string,
     *     poster_path: ?string,
     *     poster_url: ?string,
     *     poster_webp_path: ?string,
     *     poster_webp_url: ?string,
     *     original_size: int,
     *     compressed_size: int,
     *     reduction_percent: float
     * }
     */
    public function storeWithOptimization(UploadedFile $file, string $folder): array
    {
        $disk = Storage::disk('public');

        if ($this->optimizationService->isAvailable()) {
            $opt = $this->optimizationService->optimizeHeroVideo($file, $folder);

            return [
                'path' => $opt['mp4_path'],
                'url' => $disk->url($opt['mp4_path']),
                'stream_url' => route('media.stream', ['path' => $opt['mp4_path']]),
                'webm_path' => $opt['webm_path'],
                'webm_url' => $opt['webm_path'] ? route('media.stream', ['path' => $opt['webm_path']]) : null,
                'poster_path' => $opt['poster_path'],
                'poster_url' => $opt['poster_path'] ? $disk->url($opt['poster_path']) : null,
                'poster_webp_path' => $opt['poster_webp_path'],
                'poster_webp_url' => $opt['poster_webp_path'] ? $disk->url($opt['poster_webp_path']) : null,
                'original_size' => $opt['original_size'],
                'compressed_size' => $opt['compressed_size'],
                'reduction_percent' => $opt['reduction_percent'],
            ];
        }

        // Fallback if optimization tools are not available
        $extension = $file->getClientOriginalExtension() ?: $file->guessExtension();
        $filename = Str::uuid().'.'.$extension;
        $path = $folder.'/'.$filename;

        $disk->putFileAs($folder, $file, $filename);

        $fileSize = $file->getSize() ?: 0;

        return [
            'path' => $path,
            'url' => $disk->url($path),
            'stream_url' => route('media.stream', ['path' => $path]),
            'webm_path' => null,
            'webm_url' => null,
            'poster_path' => null,
            'poster_url' => null,
            'poster_webp_path' => null,
            'poster_webp_url' => null,
            'original_size' => $fileSize,
            'compressed_size' => $fileSize,
            'reduction_percent' => 0.0,
        ];
    }
}
