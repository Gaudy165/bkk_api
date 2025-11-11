<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartnerCompanyStoreRequest extends FormRequest
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
            'name' => 'required|string|max:150',
            'logo' => 'nullable|image|max:2048',
            'industry' => 'nullable|string|max:150',
            'status' => 'nullable|in:active,inactive',
            'partnership_date' => 'nullable|date',
            'website' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ];
    }
}
