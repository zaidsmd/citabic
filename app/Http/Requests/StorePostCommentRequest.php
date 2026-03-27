<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'content' => ['required', 'string', 'min:5', 'max:3000'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('site.blog.comments.validation.name_required'),
            'email.required' => __('site.blog.comments.validation.email_required'),
            'email.email' => __('site.blog.comments.validation.email_email'),
            'content.required' => __('site.blog.comments.validation.content_required'),
            'content.min' => __('site.blog.comments.validation.content_min'),
        ];
    }
}
