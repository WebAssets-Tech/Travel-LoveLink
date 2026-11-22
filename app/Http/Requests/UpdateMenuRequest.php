<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMenuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Ensure authorization is handled via middleware
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title'      => 'required|string|max:255',
            'parent_id'  => 'nullable|integer|exists:menus,id',
            'order'      => 'required|integer|min:1',
            'link'      => 'nullable|string|max:255',
            'type'      => 'required|in:0,1,2',
            'status'    => 'required|in:0,1',
        ];
    }
}
