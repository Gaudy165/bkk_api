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
            'id' => $this->id,
            'job_vacancy_id' => $this->job_vacancy_id,
            'major_id' => $this->major_id,
            'full_name' => $this->full_name,
            'nis_nisn' => $this->nis_nisn,
            'birth_date' => $this->birth_date?->toDateString(),
            'gender' => $this->gender,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
            'graduation_year' => $this->graduation_year,
            'gpa' => $this->gpa,
            'work_experience' => $this->work_experience,
            'apply_reason' => $this->apply_reason,
            'resume' => $this->resume_path ? asset('storage/'.$this->resume_path) : null,
            'certificate' => $this->certificate_path ? asset('storage/'.$this->certificate_path) : null,
            'photo' => $this->photo_path ? asset('storage/'.$this->photo_path) : null,
            'cover_letter' => $this->cover_letter_path ? asset('storage/'.$this->cover_letter_path) : null,
            'status' => $this->status,
            'read_at' => $this->read_at?->toISOString(),
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
