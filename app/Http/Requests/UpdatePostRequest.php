<?php

namespace App\Http\Requests;

use App\Enums\PostStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string'],
            'status' => ['required', Rule::enum(PostStatus::class)],
            'featured_image' => ['nullable', 'string'],
            'featured' => ['nullable', 'boolean'],
            'allow_comments' => ['nullable', 'boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'focus_keyword' => ['nullable', 'string', 'max:255'],
            'twitter_card' => ['nullable', 'in:summary,summary_large_image,app,player'],
            'robots_index' => ['nullable', 'boolean'],
            'robots_follow' => ['nullable', 'boolean'],
            'schema_type' => ['nullable', 'string', 'max:100'],
            'schema_json' => ['nullable', 'json'],
            'blocks' => ['nullable', 'array'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['nullable', 'string', 'max:255'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['nullable', 'string', 'max:255'],
            'en' => ['nullable', 'array'],
            'en.title' => ['nullable', 'string', 'max:255'],
            'en.excerpt' => ['nullable', 'string'],
            'ar' => ['nullable', 'array'],
            'ar.title' => ['nullable', 'string', 'max:255'],
            'ar.excerpt' => ['nullable', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $blocks = $this->input('blocks');
        $schemaJson = $this->input('schema_json');

        if (is_string($blocks)) {
            $decodedBlocks = json_decode($blocks, true);
            $this->merge([
                'blocks' => is_array($decodedBlocks) ? $decodedBlocks : [],
            ]);
        }

        if ($schemaJson === '') {
            $this->merge(['schema_json' => null]);
        }
    }
}
