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

    public ?bool $submitButton;

    public function __construct(
        string $title,
        ?string $subtitle = null,
        ?string $backUrl = null,
        ?string $backLabel = null,
        ?string $actionUrl = null,
        ?string $actionLabel = null,
        ?bool $submitButton = false
    ) {
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->backUrl = $backUrl;
        $this->backLabel = $backLabel ?? __('admin.common.back');
        $this->actionUrl = $actionUrl;
        $this->actionLabel = $actionLabel ?? __('admin.common.save');
        $this->submitButton = $submitButton;
    }

    public function render()
    {
        return view('components.admin.page-header');
    }
}
