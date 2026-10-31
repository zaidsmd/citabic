<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

/**
 * Service to optimize, compress, and generate streaming-ready assets for videos.
 */
class VideoOptimizationService
{
    protected ?bool $ffmpegAvailable = null;

    /**
     * Check if FFmpeg is installed and available in the system path.
     */
    public function isAvailable(): bool
    {
        if ($this->ffmpegAvailable !== null) {
            return $this->ffmpegAvailable;
        }

        try {
            $process = new Process(['ffmpeg', '-version']);
            $process->run();
            $this->ffmpegAvailable = $process->isSuccessful();
        } catch (\Throwable $e) {
            $this->ffmpegAvailable = false;
        }

        return $this->ffmpegAvailable;
    }

    /**
     * Compress and optimize a hero video, generating faststart MP4, WebM, and poster thumbnails.
     *
     * @param  UploadedFile|string  $source  Path to file or UploadedFile instance
     * @param  string  $folder  Target storage folder on public disk
     * @param  string|null  $customBaseName  Optional base UUID or filename without extension
     * @return array{
     *     mp4_path: string,
     *     webm_path: ?string,
     *     poster_path: ?string,
     *     poster_webp_path: ?string,
     *     original_size: int,
     *     compressed_size: int,
     *     reduction_percent: float
     * }
     */
    public function optimizeHeroVideo(UploadedFile|string $source, string $folder = 'hero', ?string $customBaseName = null): array
    {
        if (function_exists('set_time_limit')) {
            @set_time_limit(300);
        }

        $sourcePath = $source instanceof UploadedFile ? $source->getRealPath() : $source;
        $originalSize = file_exists($sourcePath) ? (int) filesize($sourcePath) : 0;
        $baseName = $customBaseName ?: (string) Str::uuid();

        $storageDisk = Storage::disk('public');
        $targetDir = $storageDisk->path($folder);

        if (! is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $mp4Filename = "{$baseName}.mp4";
        $mp4RelativePath = "{$folder}/{$mp4Filename}";
        $mp4FullPath = $targetDir.DIRECTORY_SEPARATOR.$mp4Filename;

        $webmFilename = "{$baseName}.webm";
        $webmRelativePath = "{$folder}/{$webmFilename}";
        $webmFullPath = $targetDir.DIRECTORY_SEPARATOR.$webmFilename;

        $posterJpgFilename = "{$baseName}-poster.jpg";
        $posterJpgRelativePath = "{$folder}/{$posterJpgFilename}";
        $posterJpgFullPath = $targetDir.DIRECTORY_SEPARATOR.$posterJpgFilename;

        $posterWebpFilename = "{$baseName}-poster.webp";
        $posterWebpRelativePath = "{$folder}/{$posterWebpFilename}";
        $posterWebpFullPath = $targetDir.DIRECTORY_SEPARATOR.$posterWebpFilename;

        // If FFmpeg is not available, perform fallback storage
        if (! $this->isAvailable()) {
            Log::warning('FFmpeg is not available. Saving video without optimization.');
            if ($source instanceof UploadedFile) {
                $storageDisk->putFileAs($folder, $source, $mp4Filename);
            } else {
                copy($sourcePath, $mp4FullPath);
            }

            return [
                'mp4_path' => $mp4RelativePath,
                'webm_path' => null,
                'poster_path' => null,
                'poster_webp_path' => null,
                'original_size' => $originalSize,
                'compressed_size' => file_exists($mp4FullPath) ? (int) filesize($mp4FullPath) : $originalSize,
                'reduction_percent' => 0.0,
            ];
        }

        $tempMp4 = tempnam(sys_get_temp_dir(), 'hero_mp4_').'.mp4';
        $tempWebm = tempnam(sys_get_temp_dir(), 'hero_webm_').'.webm';
        $tempPosterJpg = tempnam(sys_get_temp_dir(), 'hero_p_jpg_').'.jpg';
        $tempPosterWebp = tempnam(sys_get_temp_dir(), 'hero_p_webp_').'.webp';

        try {
            // 1. Generate Web-Optimized H.264 MP4 with faststart (moov atom at start) and muted audio
            $mp4Command = [
                'ffmpeg', '-y',
                '-i', $sourcePath,
                '-vf', "scale='min(1920,iw)':-2",
                '-c:v', 'libx264',
                '-crf', '28',
                '-maxrate', '2000k',
                '-bufsize', '3000k',
                '-preset', 'veryfast',
                '-movflags', '+faststart',
                '-pix_fmt', 'yuv420p',
                '-an',
                $tempMp4,
            ];

            $processMp4 = new Process($mp4Command);
            $processMp4->setTimeout(300);
            $processMp4->run();

            if ($processMp4->isSuccessful() && file_exists($tempMp4) && filesize($tempMp4) > 0) {
                rename($tempMp4, $mp4FullPath);
            } else {
                Log::warning('FFmpeg MP4 compression failed, falling back to original: '.$processMp4->getErrorOutput());
                if ($source instanceof UploadedFile) {
                    $storageDisk->putFileAs($folder, $source, $mp4Filename);
                } else {
                    copy($sourcePath, $mp4FullPath);
                }
            }

            // 2. Generate Poster JPEG
            $posterJpgCommand = [
                'ffmpeg', '-y',
                '-ss', '00:00:01',
                '-i', $mp4FullPath,
                '-frames:v', '1',
                '-q:v', '2',
                '-update', '1',
                $tempPosterJpg,
            ];
            $processPosterJpg = new Process($posterJpgCommand);
            $processPosterJpg->setTimeout(30);
            $processPosterJpg->run();
            if ($processPosterJpg->isSuccessful() && file_exists($tempPosterJpg) && filesize($tempPosterJpg) > 0) {
                rename($tempPosterJpg, $posterJpgFullPath);
            }

            // 3. Generate Poster WebP
            $posterWebpCommand = [
                'ffmpeg', '-y',
                '-ss', '00:00:01',
                '-i', $mp4FullPath,
                '-frames:v', '1',
                '-q:v', '75',
                $tempPosterWebp,
            ];
            $processPosterWebp = new Process($posterWebpCommand);
            $processPosterWebp->setTimeout(30);
            $processPosterWebp->run();
            if ($processPosterWebp->isSuccessful() && file_exists($tempPosterWebp) && filesize($tempPosterWebp) > 0) {
                rename($tempPosterWebp, $posterWebpFullPath);
            }

            // 4. Generate WebM (VP9)
            $webmCommand = [
                'ffmpeg', '-y',
                '-i', $mp4FullPath,
                '-c:v', 'libvpx-vp9',
                '-b:v', '1500k',
                '-crf', '32',
                '-deadline', 'realtime',
                '-cpu-used', '5',
                '-an',
                $tempWebm,
            ];
            $processWebm = new Process($webmCommand);
            $processWebm->setTimeout(300);
            $processWebm->run();
            if ($processWebm->isSuccessful() && file_exists($tempWebm) && filesize($tempWebm) > 0) {
                rename($tempWebm, $webmFullPath);
            }
        } finally {
            // Clean up temporary files if any remain
            foreach ([$tempMp4, $tempWebm, $tempPosterJpg, $tempPosterWebp] as $tempFile) {
                if (file_exists($tempFile)) {
                    @unlink($tempFile);
                }
            }
        }

        $compressedSize = file_exists($mp4FullPath) ? (int) filesize($mp4FullPath) : $originalSize;
        $reduction = $originalSize > 0 ? round((($originalSize - $compressedSize) / $originalSize) * 100, 1) : 0.0;

        return [
            'mp4_path' => $mp4RelativePath,
            'webm_path' => file_exists($webmFullPath) ? $webmRelativePath : null,
            'poster_path' => file_exists($posterJpgFullPath) ? $posterJpgRelativePath : null,
            'poster_webp_path' => file_exists($posterWebpFullPath) ? $posterWebpRelativePath : null,
            'original_size' => $originalSize,
            'compressed_size' => $compressedSize,
            'reduction_percent' => max(0.0, $reduction),
        ];
    }
}
