<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDestinationWeddingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'banner_image' => 'nullable|image|max:2048',
            'page_bg_image' => 'nullable|image|max:2048',
            'highlights' => 'nullable|array',
            'highlights.*' => 'nullable|string|max:255',
            'gallery' => 'nullable|array',
            'gallery.*' => 'nullable|image|max:2048',
            'meta_title' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'status' => 'nullable|boolean',
            'type' => 'nullable|boolean',
        ];
    } 
    public function messages(): array
    {
        return [
            'title.required' => 'The title field is required.',
            'image.image' => 'The image must be an image file.',
            'image.max' => 'The image may not be greater than 2MB.',
            'banner_image.image' => 'The banner image must be an image file.',
            'banner_image.max' => 'The banner image may not be greater than 2MB.',
            'page_bg_image.image' => 'The page background image must be an image file.',
            'page_bg_image.max' => 'The page background image may not be greater than 2MB.',
        ];
    }
}