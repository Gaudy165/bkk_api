<?php

namespace App\Http\Requests;

class GalleryStoreRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Izinkan semua user (biasanya sudah dibatasi di middleware)
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category' => 'nullable|string|max:150',
            'title' => 'required|string|max:255',
            'image' => 'required|image|max:2048',
            'description' => 'nullable|string|max:500',
            'is_published' => 'boolean',
        ];
    }
}
