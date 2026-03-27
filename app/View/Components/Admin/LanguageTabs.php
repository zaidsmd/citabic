<?php

namespace App\View\Components\Admin;

use AllowDynamicProperties;
use Illuminate\View\Component;

class LanguageTabs extends Component
{
    public array $locales;
    public string $idPrefix;

    public function __construct(array $locales = ['fr', 'en'],string $idPrefix = '')
    {
        $this->idPrefix = $idPrefix;
        $this->locales = $locales;
    }

    public function render()
    {
        return view('components.admin.language-tabs');
    }
}
