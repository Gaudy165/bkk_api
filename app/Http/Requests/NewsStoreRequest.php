<?php

namespace App\Http\Requests;

class NewsStoreRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

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
