<?php

namespace App\Http\Requests;

class GalleryUpdateRequest extends ApiFormRequest
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
            'category' => 'sometimes|nullable|string|max:150',
            'title' => 'sometimes|required|string|max:255',
            'image' => 'sometimes|nullable|image|max:2048',
            'description' => 'sometimes|nullable|string|max:500',
            'is_published' => 'sometimes|boolean',
        ];
    }
}
