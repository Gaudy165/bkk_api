<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_vacancy_id',
        'major_id',
        'full_name',
        'nis_nisn',
        'birth_date',
        'gender',
        'address',
        'phone',
        'email',
        'graduation_year',
        'gpa',
        'work_experience',
        'apply_reason',
        'resume_path',
        'certificate_path',
        'photo_path',
        'cover_letter_path',
        'status',
        'read_at',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'graduation_year' => 'integer',
        'gpa' => 'decimal:2',
        'read_at' => 'datetime',
    ];

    public function jobVacancy(): BelongsTo
    {
        return $this->belongsTo(JobVacancy::class);
    }

    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class);
    }

    public function scopeSearch($query, ?string $term)
    {
        return $term ? $query->where(
            fn($q) => $q
                ->where('full_name', 'like', "%{$term}%")
                ->orWhere('email', 'like', "%{$term}%")
                ->orWhere('phone', 'like', "%{$term}%")
        ) : $query;
    }

    public function scopeStatus($query, ?string $status)
    {
        return $status ? $query->where('status', $status) : $query;
    }

    public function scopeForJob($query, ?int $jobVacancyId)
    {
        return $jobVacancyId ? $query->where('job_vacancy_id', $jobVacancyId) : $query;
    }
}
