<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class PageHeader extends Component
{
    public string $title;

    public ?string $subtitle;

    public ?string $backUrl;

    public ?string $backLabel;

    public ?string $actionUrl;

    public ?string $actionLabel;

    public function __construct(
        string $title,
        ?string $subtitle = null,
        ?string $backUrl = null,
        ?string $backLabel = null,
        ?string $actionUrl = null,
        ?string $actionLabel = null
    ) {
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->backUrl = $backUrl;
        $this->backLabel = $backLabel ?? __('admin.common.back');
        $this->actionUrl = $actionUrl;
        $this->actionLabel = $actionLabel ?? __('admin.common.save');
    }

    public function render()
    {
        return view('components.admin.page-header');
    }
}
