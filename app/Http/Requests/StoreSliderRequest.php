<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSliderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Set to true if all users can create a slider
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'spiti_is_colder' => 'nullable|string|max:255',
            'contact_us' => 'nullable|string|max:255',
            'domestic_trip' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',  
            'buttons' => 'nullable|array',
            'buttons.*.buttons_title' => 'nullable|string|max:255',
            'buttons.*.buttons_link' => 'nullable|string|max:255',
        ];
    }
}
