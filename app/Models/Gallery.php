<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    use SoftDeletes;

    protected $fillable = ['image_path','description','is_published'];
    protected $casts = ['is_published' => 'boolean'];

    // Cari pada deskripsi (opsional bisa tambah nama file)
    public function scopeSearch($q, ?string $term) // $q = query builder, $term = search term
    {
        return $term ? $q->where('description', 'like', "%{$term}%") : $q;
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
