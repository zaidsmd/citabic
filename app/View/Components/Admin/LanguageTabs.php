<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class LanguageTabs extends Component
{
    public array $locales;

    public string $idPrefix;

    public function __construct(?array $locales = null, string $idPrefix = '')
    {
        $this->idPrefix = $idPrefix;
        $this->locales = $locales ?? config('localization.supported', ['fr', 'en', 'ar']);
    }

    public function render()
    {
        return view('components.admin.language-tabs');
    }
}
