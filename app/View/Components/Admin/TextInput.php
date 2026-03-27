<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class TextInput extends Component
{
    public string $name;

    public string $label;

    public ?string $value;

    public bool $required;

    public ?string $locale;

    public ?string $type;

    public function __construct(
        string $name,
        string $label,
        ?string $value = null,
        bool $required = false,
        ?string $locale = null,
        string $type = 'text'
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->required = $required;
        $this->locale = $locale;
        $this->type = $type;
    }

    public function render()
    {
        return view('components.admin.text-input');
    }
}
