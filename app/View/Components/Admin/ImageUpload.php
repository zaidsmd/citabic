<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class ImageUpload extends Component
{
    public string $key;

    public string $label;

    public ?string $value;

    public string $uploadRoute;

    public ?string $size;

    public function __construct(
        string $key,
        string $label,
        ?string $value = null,
        string $uploadRoute = 'admin.pages.about-us.upload-image',
        ?string $size = null
    ) {
        $this->key = $key;
        $this->label = $label;
        $this->value = $value;
        $this->uploadRoute = $uploadRoute;
        $this->size = $size;
    }

    public function render()
    {
        return view('components.admin.image-upload');
    }
}
