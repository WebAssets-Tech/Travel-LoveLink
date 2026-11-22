<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCabRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'cab_type' => 'required|string',
            'status' => 'required|boolean',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
              'highlights' => 'nullable|array',
            'highlights.*' => 'nullable|string|max:255',
            'footer_gallery' => 'nullable|array',
            'meta_description' => 'nullable|string',
            'seating_capacity' => 'required|integer',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg',
            'page_bg_image' => 'nullable|image|mimes:jpeg,png,jpg',
        ];
    }
}
