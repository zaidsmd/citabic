<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class StatusMessages extends Component
{
    public ?string $status;

    public ?string $error;

    public array $errors;

    public function __construct()
    {
        $this->status = session('status');
        $this->error = session('error');
        $this->errors = session('errors')?->all() ?? [];
    }

    public function shouldRender(): bool
    {
        return ! empty($this->status) || ! empty($this->error) || ! empty($this->errors);
    }

    public function render()
    {
        return view('components.admin.status-messages');
    }
}
