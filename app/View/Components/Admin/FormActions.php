<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class FormActions extends Component
{
    public ?string $saveLabel;

    public ?string $cancelLabel;

    public ?string $cancelUrl;

    public bool $showReset;

    public ?string $resetLabel;

    public array $additionalActions;

    public function __construct(
        ?string $saveLabel = null,
        ?string $cancelLabel = null,
        ?string $cancelUrl = null,
        bool $showReset = true,
        ?string $resetLabel = null,
        array $additionalActions = []
    ) {
        $this->saveLabel = $saveLabel ?? __('admin.common.save');
        $this->cancelLabel = $cancelLabel ?? __('admin.common.cancel');
        $this->cancelUrl = $cancelUrl;
        $this->showReset = $showReset;
        $this->resetLabel = $resetLabel ?? __('admin.common.reset');
        $this->additionalActions = $additionalActions;
    }

    public function render()
    {
        return view('components.admin.form-actions');
    }
}
