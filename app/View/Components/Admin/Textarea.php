<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class Textarea extends Component
{
    public string $name;

    public string $label;

    public ?string $value;

    public bool $required;

    public ?string $locale;

    public int $rows;

    public function __construct(
        string $name,
        string $label,
        ?string $value = null,
        bool $required = false,
        ?string $locale = null,
        int $rows = 6
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->required = $required;
        $this->locale = $locale;
        $this->rows = $rows;
    }

    public function render()
    {
        return view('components.admin.textarea');
    }
}
