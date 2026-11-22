<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
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
            'title'              => 'required|string|max:255',
            'price'             => 'required|numeric|min:0',
            'status'            => 'required|boolean',
            'description'       => 'nullable|string',
            'highlights'        => 'nullable|array',
            'highlights.*'      => 'string|max:255',
            'meta_title'        => 'nullable|string|max:255',
            'meta_keywords'     => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string|max:255',
            'additional_images' => 'nullable|array',
            'additional_images.*' => 'file|image|max:2048', // Each must be an image file under 2MB
            'image'             => 'nullable|file|image|max:2048',
            'page_bg_image'     => 'nullable|file|image|max:2048',
            'banner_image'      => 'nullable|file|image|max:2048',
            'banner_footer_image' => 'nullable|file|image|max:2048',
        ];
    }
}
