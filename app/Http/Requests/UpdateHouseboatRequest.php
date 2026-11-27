<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHouseboatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'star_rating' => 'nullable|integer|min:1|max:5',
            'location' => 'nullable|string|max:255',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'page_bg_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'banner_footer_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'highlights' => 'nullable|array',
            'highlights.*' => 'nullable|string|max:255',
            'additional_images' => 'nullable|array',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'status' => 'nullable|boolean',
        ];
    }
}
