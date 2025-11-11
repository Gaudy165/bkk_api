<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsUpdateRequest extends FormRequest
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
            'title' => 'sometimes|required|string|max:200',
            'news_category_id' => 'sometimes|nullable|exists:news_categories,id',
            'content' => 'sometimes|nullable|string',
            'thumbnail' => 'sometimes|nullable|image|max:2048',
            'status' => 'sometimes|in:draft,published',
            'published_at' => 'sometimes|nullable|date',
        ];
    }
}
