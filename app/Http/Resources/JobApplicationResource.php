<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobApplicationResource extends JsonResource
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
            'name'=>$this->name,
            'position'=>$this->position,
            'graduation_year'=>$this->graduation_year,
            'graduation_date'=>$this->graduation_date?->toDateString(),
            'email'=>$this->email,
            'phone'=>$this->phone,
            'resume_url'=>$this->resume_path ? asset('storage/' . $this->resume_path) : null,
            'status'=>$this->status,
            'created_at'=>$this->created_at->toISOString(),
        ];
    }
}
