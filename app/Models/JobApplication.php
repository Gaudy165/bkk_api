<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobApplication extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'position', 'graduation_year', 'graduation_date', 'email', 'phone', 'resume_path', 'status'];
    protected $casts = ['graduation_date' => 'date'];

    // Cari nama, posisi, email, telp
    public function scopeSearch($q, ?string $term) // $q = query builder, $term = search term
    {
        // fn = function, $qq = sub query builder
        return $term ? $q->where(fn($qq) => $qq
            ->where('name', 'like', "%{$term}%")
            ->orWhere('position', 'like', "%{$term}%")
            ->orWhere('email', 'like', "%{$term}%")
            ->orWhere('phone', 'like', "%{$term}%")
        ) : $q;
    }

    // Filter status: not_processed|in_progress|accepted|rejected
    public function scopeStatus($q, ?string $status)
    {
        return $status ? $q->where('status', $status) : $q;
    }
}
