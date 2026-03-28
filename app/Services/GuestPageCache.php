<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

/**
 * Provides domain logic for Guest Page Cache.
 */
class GuestPageCache
{
    /**
     * Build a versioned cache key for guest-facing content.
     *
     * @param  string  $base  Parameter.
     */
    public function key(string $base): string
    {
        return $base.':v'.$this->version();
    }

    /**
     * Increment the guest cache version to invalidate stale entries.
     */
    public function bump(): int
    {
        $newVersion = $this->version() + 1;
        Cache::forever('guest_pages_cache_version', $newVersion);

        return $newVersion;
    }

    /**
     * Return the active guest cache version value.
     */
    public function version(): int
    {
        return (int) Cache::get('guest_pages_cache_version', 1);
    }
}
