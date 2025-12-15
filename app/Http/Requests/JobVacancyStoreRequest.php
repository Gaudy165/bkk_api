<?php

namespace App\Http\Requests;

class JobVacancyStoreRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company' => 'required|string|max:255',
            'image' => 'nullable|image|max:4096',
            'position' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date|required_with:start_date',
            'description' => 'required|string',
            'qualifications' => 'required|array|min:1',
            'qualifications.*' => 'string',
            'job_type' => 'nullable|string|max:100',
            'working_hours' => 'nullable|string|max:255',
            'benefits' => 'nullable|array',
            'benefits.*' => 'string',
            'quota' => 'nullable|integer|min:0',
            'majors' => 'nullable|array',
            'majors.*' => 'string',
        ];
    }

    public function messages(): array
    {
        return [
            'company.required' => 'Nama perusahaan wajib diisi.',
            'location.required' => 'Lokasi pekerjaan wajib diisi.',
            'position.required' => 'Posisi pekerjaan wajib diisi.',
            'description.required' => 'Deskripsi pekerjaan wajib diisi.',
            'image.image' => 'File harus berupa gambar.',
            'image.max' => 'Ukuran gambar maksimal 4 MB.',
            'qualifications.required' => 'Kualifikasi wajib diisi.',
            'qualifications.array' => 'Format kualifikasi tidak valid.',
            'qualifications.min' => 'Minimal satu kualifikasi harus diisi.',
            'qualifications.*.string' => 'Setiap kualifikasi harus berupa teks.',
            'start_date.date' => 'Tanggal mulai harus berupa format tanggal yang valid.',
            'end_date.date' => 'Tanggal berakhir harus berupa format tanggal yang valid.',
            'end_date.after_or_equal' => 'Tanggal berakhir tidak boleh lebih awal dari tanggal mulai.',
            'end_date.required_with' => 'Tanggal berakhir wajib diisi jika tanggal mulai diisi.',
            'quota.integer' => 'Kuota harus berupa angka.',
            'quota.min' => 'Kuota tidak boleh kurang dari 0.',
        ];
    }
}
