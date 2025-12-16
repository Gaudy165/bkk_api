<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class JobApplicationStoreRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'job_vacancy_id' => ['required', 'integer', 'exists:job_vacancies,id'],
            'major_id' => ['required', 'integer', 'exists:majors,id'],
            'full_name' => ['required', 'string', 'max:150'],
            'nis_nisn' => ['nullable', 'string', 'max:30'],
            'birth_date' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:male,female'],
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('job_applications', 'email')
                    ->where(fn($query) => $query->where('job_vacancy_id', $this->input('job_vacancy_id'))),
            ],
            'graduation_year' => [
                'nullable',
                'digits:4',
                'integer',
                'min:1980',
                'max:' . date('Y'),
            ],
            'gpa' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'work_experience' => ['nullable', 'string'],
            'apply_reason' => ['required', 'string', 'min:20'],
            'resume' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'certificate' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
            'cover_letter' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'job_vacancy_id.required' => 'Lowongan pekerjaan wajib dipilih.',
            'job_vacancy_id.exists'   => 'Lowongan pekerjaan tidak valid.',
            'major_id.required' => 'Jurusan wajib dipilih.',
            'major_id.exists'   => 'Jurusan tidak valid.',
            'full_name.required' => 'Nama lengkap wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah digunakan untuk lowongan ini.',
            'graduation_year.min' => 'Tahun kelulusan minimal 1980.',
            'apply_reason.required' => 'Alasan melamar wajib diisi.',
            'apply_reason.min'      => 'Alasan melamar minimal 20 karakter.',
            'resume.required' => 'CV wajib diunggah.',
            'resume.mimes'    => 'CV harus berupa PDF atau Word.',
            'resume.max'      => 'Ukuran CV maksimal 2MB.',
        ];
    }

    /**
     * Normalisasi data sebelum divalidasi
     * (opsional tapi rapi)
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('email')) {
            $this->merge([
                'email' => strtolower(trim($this->email)),
            ]);
        }
    }
}
