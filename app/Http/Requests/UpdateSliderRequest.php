<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSliderRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Allow all users
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'spiti_is_colder' => 'nullable|string|max:255',
            'contact_us' => 'nullable|string|max:255',
            'domestic_trip' => 'nullable|string|max:255',

            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'buttons' => 'nullable|array',
            'buttons.*.buttons_title' => 'nullable|string|max:255',
            'buttons.*.buttons_link' => 'nullable|string|max:255',
        ];
    }
}
