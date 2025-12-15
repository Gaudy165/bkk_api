<?php

namespace App\Http\Requests;

class TestimonialUpdateRequest extends ApiFormRequest
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
            'user_name' => 'sometimes|required|string|max:150',
            'company' => 'sometimes|nullable|string|max:150',
            'content' => 'sometimes|required|string',
            'avatar' => 'sometimes|nullable|image|max:2048',
        ];
    }
}
