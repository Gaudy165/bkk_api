<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicJobVacancyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'company' => $this->company,
            'position' => $this->position,
            'location' => $this->location,
            'image_url' => $this->image_path ? asset('storage/' . $this->image_path) : null,
            'date_posted' => optional($this->date_posted)->toISOString(),
            'views' => $this->views,
            'job_type' => $this->job_type,
            'majors' => $this->majors ?? [],
        ];
    }
}
