<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDestinationRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Change to false if authorization is needed
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:destinations,name,' . $this->route('destination')->id,
            'location' => 'required|string|max:255',
            'status' => 'required|boolean',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'highlights' => 'nullable|array',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:destination_category,id',
            'highlights.*' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'page_bg_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner_footer_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
