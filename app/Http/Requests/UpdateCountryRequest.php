<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCountryRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:191',
                Rule::unique('countries', 'name')->ignore($this->country),
            ],
            'code'                 => 'nullable|string|max:5',
            'status'               => 'nullable|boolean',
            'image'                => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'page_bg_image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banner_image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banner_footer_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'additional_images'    => 'nullable|array',
            'additional_images.*'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'delete_images'        => 'nullable|array',
            'delete_images.*'      => 'nullable|string',
        ];
    }
}