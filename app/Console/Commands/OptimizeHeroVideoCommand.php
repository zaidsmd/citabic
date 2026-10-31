<?php

namespace App\Console\Commands;

use App\Enums\ContentKey;
use App\Enums\Section;
use App\Models\SectionContent;
use App\Services\VideoOptimizationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class OptimizeHeroVideoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hero:optimize-video
                            {path? : Optional relative path in public storage to optimize}
                            {--force : Force re-optimization even if already optimized}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compress and optimize the hero video for instant web streaming and poster generation';

    /**
     * Execute the console command.
     */
    public function handle(VideoOptimizationService $optimizationService): int
    {
        $this->info('Checking video optimization tools...');

        if (! $optimizationService->isAvailable()) {
            $this->error('FFmpeg is not available in system PATH. Cannot optimize video.');

            return self::FAILURE;
        }

        $targetPath = $this->argument('path');

        if (! $targetPath) {
            $targetPath = SectionContent::where('section', Section::HERO)
                ->where('key', ContentKey::HERO_VIDEO->value)
                ->value('value');
        }

        if (! $targetPath) {
            $this->warn('No hero video found in database section_contents or provided via argument.');

            return self::FAILURE;
        }

        $disk = Storage::disk('public');
        $cleanPath = ltrim(str_replace('storage/', '', $targetPath), '/');

        if (! $disk->exists($cleanPath)) {
            $this->error("Target video not found on public storage disk: [{$cleanPath}]");

            return self::FAILURE;
        }

        $fullPath = $disk->path($cleanPath);
        $folder = dirname($cleanPath);
        $folder = $folder === '.' ? 'hero' : $folder;
        $baseName = pathinfo($cleanPath, PATHINFO_FILENAME);

        $this->info("Found target video: [{$cleanPath}] (".round(filesize($fullPath) / (1024 * 1024), 2).' MB)');
        $this->info('Starting compression and optimization...');

        // If the file is already named like a uuid and we want to optimize it in-place
        // We'll backup the original file first if not backed up yet
        $backupPath = $folder.DIRECTORY_SEPARATOR.$baseName.'.original.'.pathinfo($cleanPath, PATHINFO_EXTENSION);
        if (! $disk->exists($backupPath)) {
            $this->line("Creating backup of original video: [{$backupPath}]");
            copy($fullPath, $disk->path($backupPath));
        }

        $sourceToUse = $disk->path($backupPath);

        $result = $optimizationService->optimizeHeroVideo($sourceToUse, $folder, $baseName);

        $originalMb = round($result['original_size'] / (1024 * 1024), 2);
        $compressedMb = round($result['compressed_size'] / (1024 * 1024), 2);

        $this->table(
            ['Asset', 'Path', 'Status'],
            [
                ['Optimized MP4 (faststart)', $result['mp4_path'], 'Created / Updated'],
                ['WebM (VP9)', $result['webm_path'] ?? 'N/A', $result['webm_path'] ? 'Created' : 'Skipped'],
                ['Poster (JPEG)', $result['poster_path'] ?? 'N/A', $result['poster_path'] ? 'Created' : 'Skipped'],
                ['Poster (WebP)', $result['poster_webp_path'] ?? 'N/A', $result['poster_webp_path'] ? 'Created' : 'Skipped'],
            ]
        );

        $this->info("Compression complete! Reduced from {$originalMb} MB to {$compressedMb} MB ({$result['reduction_percent']}% reduction).");

        return self::SUCCESS;
    }
}
