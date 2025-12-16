<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobVacancyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'company' => $this->company,
            'image' => $this->image_path ? asset('storage/' . $this->image_path) : null,
            'date_posted' => $this->date_posted?->toDateString(),
            'status' => $this->status,
            'views' => $this->views,
            'location' => $this->location,
            'position' => $this->position,
            'salary' => $this->salary,
            'start_date' => $this->start_date?->toDateString(),
            'end_date' => $this->end_date?->toDateString(),
            'description' => $this->description,
            'qualifications' => $this->qualifications ?? [],
            'job_type' => $this->job_type,
            'working_hours' => $this->working_hours,
            'benefits' => $this->benefits ?? [],
            'quota' => $this->quota,
            'majors' => $this->majors ?? [],
            'created_at' => $this->created_at->toISOString(),
        ];
    }
}
