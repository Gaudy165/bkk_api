<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    protected $fillable = ['name', 'slug'];

    // Cari nama, slug
    public function scopeSearch($q, ?string $term) // $q = query builder, $term = search term
    {
        // fn = function, $qq = sub query builder
        return $term ? $q->where(fn($qq) => $qq
            ->where('name', 'like', "%{$term}%")
            ->orWhere('slug', 'like', "%{$term}%")
        ) : $q;
    }

    // Tidak ada kolom status -> sengaja tidak dibuat scopeStatus()
}
