<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGalleryRequest extends FormRequest
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
            'title'       => 'required|string|max:255',
            'order'       => 'required|integer|min:1',
            'video_link'  => 'nullable|string|required_if:type,video',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048|required_if:type,image',
            'type'        => 'required|in:video,image',
            'status'      => 'required|boolean',
        ];
    }
}
