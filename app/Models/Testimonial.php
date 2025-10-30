<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_name', 'company', 'avatar_path', 'content', 'is_published'];
    protected $casts = ['is_published' => 'boolean'];

    // Cari nama user, perusahaan, isi ulasan
    public function scopeSearch($q, ?string $term) // $q = query builder, $term = search term
    {
        // fn = function, $qq = sub query builder
        return $term ? $q->where(fn($qq) => $qq
            ->where('user_name', 'like', "%{$term}%")
            ->orWhere('company', 'like', "%{$term}%")
            ->orWhere('content', 'like', "%{$term}%")
        ) : $q;
    }

    public function scopeStatus($q, $st)
    {
        if ($st === null || $st === '') {
            return $q;
        }
        $val = in_array(strtolower((string) $st), ['1', 'true', 'yes', 'published'], true);
        return $q->where('is_published', $val);
    }
}
