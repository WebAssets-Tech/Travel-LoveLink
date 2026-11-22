<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTouristGuideRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Change if authorization checks are needed
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'phone2' => 'nullable|string|max:20',
            'email' => 'required|email',
            'email2' => 'nullable|email',
            'rating' => 'required|integer|min:1|max:5',
            'address' => 'required|string|max:500',
            'status' => 'required|boolean',
            'language' => 'required|string|max:255',
            'experience' => 'required|integer|min:0',
            'location' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'bio' => 'nullable|string',

            'social_link' => 'nullable|array',
            'social_link.*.social_name' => 'required_with:social_link|string|max:50',
            'social_link.*.social_link' => 'required_with:social_link|string',
            'social_link.*.social_icon' => 'nullable|string|max:50',

            'details_counter' => 'nullable|array',
            'details_counter.*.count_number' => 'required_with:details_counter|string|max:10',
            'details_counter.*.count_sufix' => 'nullable|string|max:5',
            'details_counter.*.count_text' => 'required_with:details_counter|string|max:255',

            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:500',
            'meta_description' => 'nullable|string|max:1000',

            'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'page_bg_image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'banner_image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
