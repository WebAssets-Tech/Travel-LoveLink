<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTourCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Update this to implement your authorization logic
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name'              => 'required|string|max:255|unique:tour_category,name,' . $this->route('tourcategory')->id,
            'odby'              => 'required|integer',
            'status'            => 'required|boolean',
            'type'              => 'required|boolean',
            'parent_id'         => 'nullable|exists:tour_category,id',
            'description'       => 'nullable|string',
            'meta_title'        => 'nullable|string|max:255',
            'meta_keywords'     => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string|max:255',
            'additional_images' => 'nullable|array',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'page_bg_image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'banner_image'      => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'banner_footer_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
