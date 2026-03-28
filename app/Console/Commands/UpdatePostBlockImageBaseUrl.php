<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class UpdatePostBlockImageBaseUrl extends Command
{
    protected $signature = 'posts:update-block-image-base-url
        {--from= : Existing base URL to replace}
        {--to= : New base URL}
        {--dry-run : Preview changes without persisting}
        {--chunk=100 : Chunk size for processing posts}';

    protected $description = 'Replace image base URL values inside posts blocks JSON.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $fromOption = trim((string) $this->option('from'));
        $toOption = trim((string) $this->option('to'));
        $chunkSize = (int) $this->option('chunk');
        $dryRun = (bool) $this->option('dry-run');

        if ($fromOption === '' || $toOption === '') {
            $this->error('Both --from and --to options are required.');

            return self::FAILURE;
        }

        $from = rtrim($fromOption, '/');
        $to = rtrim($toOption, '/');

        if ($from === $to) {
            $this->warn('The --from and --to values are identical. Nothing to update.');

            return self::SUCCESS;
        }

        if ($chunkSize < 1) {
            $this->error('--chunk must be at least 1.');

            return self::FAILURE;
        }

        $updatedPosts = 0;
        $visitedPosts = 0;
        $replacements = 0;
        $changedPostIds = [];

        Post::query()
            ->select(['id', 'blocks'])
            ->orderBy('id')
            ->chunkById($chunkSize, function ($posts) use (
                &$updatedPosts,
                &$visitedPosts,
                &$replacements,
                &$changedPostIds,
                $from,
                $to,
                $dryRun
            ): void {
                foreach ($posts as $post) {
                    $visitedPosts++;
                    $blocks = is_array($post->blocks) ? $post->blocks : [];
                    [$updatedBlocks, $postReplacements] = $this->replaceInValue($blocks, $from, $to);

                    if ($postReplacements === 0) {
                        continue;
                    }

                    $replacements += $postReplacements;
                    $updatedPosts++;
                    $changedPostIds[] = $post->id;

                    if (! $dryRun) {
                        $post->blocks = $updatedBlocks;
                        $post->save();
                    }
                }
            });

        $this->info(sprintf(
            'Processed %d posts. %d post(s) %s. %d replacement(s) found.',
            $visitedPosts,
            $updatedPosts,
            $dryRun ? 'would be updated' : 'updated',
            $replacements
        ));

        if ($changedPostIds !== []) {
            $this->line('Changed post IDs: '.implode(', ', $changedPostIds));
        }

        return self::SUCCESS;
    }

    /**
     * Recursively replace base URLs inside mixed blocks content.
     *
     * @return array{0:mixed,1:int}
     */
    private function replaceInValue(mixed $value, string $from, string $to): array
    {
        if (is_array($value)) {
            $total = 0;

            foreach ($value as $key => $item) {
                [$updatedItem, $itemCount] = $this->replaceInValue($item, $from, $to);
                $value[$key] = $updatedItem;
                $total += $itemCount;
            }

            return [$value, $total];
        }

        if (! is_string($value) || ! Str::contains($value, $from)) {
            return [$value, 0];
        }

        $replaced = str_replace($from, $to, $value, $count);

        return [$replaced, $count];
    }
}
