<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreActivityRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'days' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'rating' => 'required|integer|min:1|max:5',
            'status' => 'required|boolean',
            'description' => 'required|string',
            'map_link' => 'nullable|url',
            'highlights' => 'nullable|array',
            'highlights.*' => 'string',
            'important_info' => 'nullable|array',
            'important_info.*' => 'string',
            'include_exclude' => 'nullable|array',
            'include_exclude.*.type' => 'required|boolean',
            'include_exclude.*.title' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'page_bg_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'additional_images' => 'nullable|array',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
