<?php

namespace App\Http\Requests;

class JobVacancyUpdateRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company' => 'sometimes|string|max:255',
            'image' => 'sometimes|nullable|image|max:4096',
            'location' => 'sometimes|string|max:255',
            'position' => 'sometimes|string|max:255',
            'salary' => 'sometimes|nullable|string|max:255',
            'start_date' => 'sometimes|nullable|date',
            'end_date' => 'sometimes|nullable|date|after_or_equal:start_date|required_with:start_date',
            'description' => 'sometimes|string',
            'qualifications' => 'sometimes|array|min:1',
            'qualifications.*' => 'string',
            'job_type' => 'sometimes|nullable|string|max:100',
            'working_hours' => 'sometimes|nullable|string|max:255',
            'benefits' => 'sometimes|nullable|array',
            'benefits.*' => 'string',
            'quota' => 'sometimes|nullable|integer|min:0',
            'majors' => 'sometimes|nullable|array',
            'majors.*' => 'string',
        ];
    }
}
