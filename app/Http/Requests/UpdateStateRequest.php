<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStateRequest extends FormRequest
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
            'country_id'           => 'required|exists:countries,id',
            'name'                 => 'required|string|max:191',
            'code'                 => 'nullable|string|max:10',
            'short_destinations'   => 'nullable|string|max:500',
            'order'                => 'nullable|integer|min:0',
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
