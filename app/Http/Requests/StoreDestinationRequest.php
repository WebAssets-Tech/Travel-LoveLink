<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDestinationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Change to false if you want to restrict access
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:destinations,name',
            'location' => 'required|string|max:255',
            'status' => 'required|boolean',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:destination_category,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'page_bg_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'banner_footer_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
