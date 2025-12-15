<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'slug'=>$this->slug,
            'category'=>$this->category?->only(['id', 'name', 'slug']),
            'thumbnail_url'=>$this->thumbnail_path ? asset('storage/' . $this->thumbnail_path) : null,
            'content'=>$this->content,
            'views'=>$this->views,
            'status'=>$this->status,
            'published_at'=>$this->published_at?->toISOString(),
            'created_at'=>$this->created_at->toISOString(),
        ];
    }
}
