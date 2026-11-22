<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePermissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // or implement permission logic
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:permissions,name|max:255',
        ];
    }
}
