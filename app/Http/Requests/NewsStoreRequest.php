<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsStoreRequest extends FormRequest
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
            'title' => 'required|string|max:200',
            'news_category_id' => 'nullable|exists:news_categories,id',
            'content' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048', // File upload
            'status' => 'in:draft,published',
            'published_at' => 'nullable|date',
        ];
    }
}
