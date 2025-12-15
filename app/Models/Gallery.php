<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = ['category', 'title', 'image_path','description','is_published'];
    protected $casts = ['is_published' => 'boolean'];

    // Cari pada judul, kategori, deskripsi
    public function scopeSearch($q, ?string $term) // $q = query builder, $term = search term
    {
        return $term ? $q->where(
            fn($qq) => $qq
                ->where('title', 'like', "%{$term}%")
                ->orWhere('category', 'like', "%{$term}%")
                ->orWhere('description', 'like', "%{$term}%")
        ) : $q;
    }

    // Status alias: published|unpublished|1|0|true|false
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
            'true' => true,
            'false' => false,
        ];
        $flag = $map[$status] ?? $status;
        return $q->where('is_published', (bool)$flag);
    }
}
