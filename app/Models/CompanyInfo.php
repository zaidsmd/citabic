<?php

namespace App\Models;

use App\Enums\CompanyInfoKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class CompanyInfo extends Model
{

    protected $fillable = [
        'key',
        'value',
        'lang',
    ];

    public function getInfo(CompanyInfoKey $key,string $lang = 'fr'): ?string
    {
        return $this->where('key', $key->value)->where('lang', $lang)->first()?->value ?? null;
    }

    public static function availableKeys(): array
    {
        return CompanyInfoKey::values();
    }

    public static function availableKeysCollection(): Collection
    {
        return CompanyInfoKey::valuesCollection();
    }

    public static function getAllInfo(string $lang = 'fr'): array
    {
        $defaults = array_fill_keys(self::availableKeys(), null);
        $stored = self::query()
            ->where('lang', $lang)
            ->pluck('value', 'key')
            ->all();

        return array_replace($defaults, $stored);
    }

}
