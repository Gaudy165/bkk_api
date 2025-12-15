<?php

namespace App\Http\Requests;

class NewsUpdateRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

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
