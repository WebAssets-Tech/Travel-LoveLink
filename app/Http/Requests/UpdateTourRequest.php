<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTourRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255', 
            'description' => 'nullable|string',
            'booking' => 'nullable|string',
            'cancellation' => 'nullable|string',
            'short_description' => 'nullable|string',
            'highlights_content' => 'nullable|string',
            'basic_content' => 'nullable|string',
            'include_exclude_content' => 'nullable|string',
            'domestic_trip' => 'nullable|string',
            'price' => 'required|numeric',
            'rating' => 'nullable|numeric|between:1,5',
            'state_id' => 'exists:states,id',
            'discount_price' => 'nullable|numeric',
            'duration' => 'required|numeric|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'page_bg_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'highlights' => 'nullable|array',
            'basic' => 'nullable|array',
            'include_exclude' => 'nullable|array',
            'itinerary' => 'nullable|array',
            'gallery' => 'nullable|array',
            'footer_gallery' => 'nullable|array',
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'status' => 'required|boolean',
            'type' => 'required|numeric',
            'venue_date' => 'nullable',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:tour_category,id',
            'destinations' => 'nullable|array',
            'destinations.*' => 'exists:destinations,id',
            'activities' => 'nullable|array',
            'activities.*' => 'exists:activities,id',
        ];
    }
}
