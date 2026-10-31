<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Controller to handle video streaming with full HTTP 206 Partial Content Range support.
 */
class VideoStreamController extends Controller
{
    /**
     * Allowed video file extensions for streaming.
     */
    protected array $allowedExtensions = ['mp4', 'webm', 'ogg'];

    /**
     * Stream a video with byte-range requests for instant playback.
     */
    public function stream(Request $request, string $path): StreamedResponse
    {
        $cleanPath = ltrim(str_replace('\\', '/', $path), '/');

        // Prevent directory traversal
        if (str_contains($cleanPath, '..') || str_contains($cleanPath, "\0")) {
            abort(403, 'Invalid path');
        }

        $extension = strtolower(pathinfo($cleanPath, PATHINFO_EXTENSION));
        if (! in_array($extension, $this->allowedExtensions, true)) {
            abort(403, 'File format not allowed for video streaming');
        }

        $disk = Storage::disk('public');
        if (! $disk->exists($cleanPath)) {
            abort(404, 'Video not found');
        }

        $fullPath = $disk->path($cleanPath);
        $fileSize = (int) filesize($fullPath);

        $mimeTypes = [
            'mp4' => 'video/mp4',
            'webm' => 'video/webm',
            'ogg' => 'video/ogg',
        ];
        $contentType = $mimeTypes[$extension] ?? 'application/octet-stream';

        $start = 0;
        $end = $fileSize - 1;
        $status = 200;

        $rangeHeader = $request->header('Range');

        if ($rangeHeader && preg_match('/bytes=\s*(\d*)-(\d*)/i', $rangeHeader, $matches)) {
            $rangeStart = $matches[1] !== '' ? (int) $matches[1] : null;
            $rangeEnd = $matches[2] !== '' ? (int) $matches[2] : null;

            if ($rangeStart === null && $rangeEnd !== null) {
                // Suffix byte range: last N bytes
                $start = max(0, $fileSize - $rangeEnd);
                $end = $fileSize - 1;
            } elseif ($rangeStart !== null) {
                $start = $rangeStart;
                if ($rangeEnd !== null) {
                    $end = min($rangeEnd, $fileSize - 1);
                } else {
                    $end = $fileSize - 1;
                }
            }

            // Cap the max chunk per range request to 2MB to keep initial latency ultra-low
            $maxChunk = 2 * 1024 * 1024;
            if (($end - $start + 1) > $maxChunk) {
                $end = $start + $maxChunk - 1;
            }

            if ($start > $end || $start >= $fileSize) {
                return response()->stream(static function () {}, 416, [
                    'Content-Range' => "bytes */{$fileSize}",
                    'Accept-Ranges' => 'bytes',
                ]);
            }

            $status = 206;
        }

        $length = $end - $start + 1;

        $headers = [
            'Content-Type' => $contentType,
            'Content-Length' => (string) $length,
            'Accept-Ranges' => 'bytes',
            'Cache-Control' => 'public, max-age=31536000, immutable',
        ];

        if ($status === 206) {
            $headers['Content-Range'] = "bytes {$start}-{$end}/{$fileSize}";
        }

        return response()->stream(function () use ($fullPath, $start, $length) {
            $fp = fopen($fullPath, 'rb');
            if (! $fp) {
                return;
            }

            if ($start > 0) {
                fseek($fp, $start);
            }

            $remaining = $length;
            $chunkSize = 64 * 1024; // 64KB read buffer

            while ($remaining > 0 && ! feof($fp)) {
                $readSize = min($chunkSize, $remaining);
                $buffer = fread($fp, $readSize);

                if ($buffer === false) {
                    break;
                }

                echo $buffer;
                flush();

                $remaining -= strlen($buffer);
            }

            fclose($fp);
        }, $status, $headers);
    }
}
