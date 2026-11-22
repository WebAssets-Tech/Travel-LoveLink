<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCabRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'cab_type' => 'required|string',
            'status' => 'required|boolean',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'highlights' => 'nullable|array',
            'highlights.*' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'seating_capacity' => 'required|integer',
            'footer_gallery' => 'nullable|array',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg',
            'page_bg_image' => 'nullable|image|mimes:jpeg,png,jpg',
        ];
    }
}
