<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = ['user_name', 'company', 'avatar_path', 'content', 'is_published'];
    protected $casts = ['is_published' => 'boolean'];

    // Cari nama user, perusahaan, isi ulasan
    public function scopeSearch($q, ?string $term) // $q = query builder, $term = search term
    {
        // fn = function, $qq = sub query builder
        return $term ? $q->where(
            fn($qq) => $qq
                ->where('user_name', 'like', "%{$term}%")
                ->orWhere('company', 'like', "%{$term}%")
                ->orWhere('content', 'like', "%{$term}%")
        ) : $q;
    }

    // Status alias: published|unpublished|1|0|true|false
    // Contoh: ?status=published atau ?status=0
    public function scopeStatus($q, $status)
    {
        if ($status === null || $status === '') {
            return $q;
        }

        $map = [
            'published' => true,
            'unpublished' => false,
            '1' => true,
            '0' => false,
            1 => true,
            0 => false,
            true => true,
            false => false,
        ];
        $flag = $map[$status] ?? $status; // Jika langsung boolean
        return $q->where('is_published', (bool)$flag);
    }
}
