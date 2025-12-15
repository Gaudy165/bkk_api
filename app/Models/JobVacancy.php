<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobVacancy extends Model
{
    use HasFactory;

    protected $fillable = [
        'company',
        'image_path',
        'location',
        'position',
        'salary',
        'start_date',
        'end_date',
        'description',
        'qualifications',
        'job_type',
        'working_hours',
        'benefits',
        'quota',
        'majors',
    ];

    // Field sistem
    protected $guarded = [
        'date_posted',
        'views',
    ];
    
    protected $casts = [
        'date_posted' => 'datetime',
        'start_date' => 'date',
        'end_date' => 'date',
        'qualifications' => 'array',
        'benefits' => 'array',
        'majors' => 'array',
        'views' => 'integer',
        'quota' => 'integer',
    ];

    // Cari berdasarkan company, posisi, lokasi, deskripsi
    public function scopeSearch($query, ?string $term)
    {
        return $term ? $query->where(
            fn($qq) => $qq
                ->where('company', 'like', "%{$term}%")
                ->orWhere('position', 'like', "%{$term}%")
                ->orWhere('location', 'like', "%{$term}%")
                ->orWhere('description', 'like', "%{$term}%")
        ) : $query;
    }
}
