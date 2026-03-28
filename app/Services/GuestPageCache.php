<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class GuestPageCache
{
    public function key(string $base): string
    {
        return $base.':v'.$this->version();
    }

    public function bump(): int
    {
        $newVersion = $this->version() + 1;
        Cache::forever('guest_pages_cache_version', $newVersion);

        return $newVersion;
    }

    public function version(): int
    {
        return (int) Cache::get('guest_pages_cache_version', 1);
    }
}
