<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobApplicationUpdateRequest extends FormRequest
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
            'name' => 'sometimes|required|string|max:150',
            'position' => 'sometimes|required|string|max:150',
            'email'   => 'sometimes|required|email|max:150',
            'resume'  => 'sometimes|nullable|file|mimes:pdf,doc,docx|max:5120', // 5MB
        ];
    }
}
