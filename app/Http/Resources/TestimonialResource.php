<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_name' => $this->user_name,
            'company' => $this->company,
            'avatar_url' => $this->avatar_path ? asset('storage/' . $this->avatar_path) : null,
            'content' => $this->content,
            'is_published' => $this->is_published,
            'created_at' => $this->created_at->toISOString(),
        ];
    }
}
