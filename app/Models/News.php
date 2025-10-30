<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['news_category_id', 'title', 'slug', 'thumbnail_path', 'content', 'views', 'status', 'published_at'];
    protected $casts = ['published_at' => 'datetime'];

    public function category()
    {
        return $this->belongsTo(NewsCategory::class, 'news_category_id');
    }

    // Cari judul dan isi berita
    public function scopeSearch($q, ?string $term) // $q = query builder, $term = search term
    {
        // fn = function, $qq = sub query builder
        return $term ? $q->where(fn($qq) => $qq
            ->where('title', 'like', "%{$term}%")
            ->orWhere('content', 'like', "%{$term}%")
        ) : $q;
    }

    public function scopeStatus($q, ?string $status)
    {
        return $status ? $q->where('status', $status) : $q;
    }

    public function scopeCategorySlug($q, ?string $slug)
    {
        return $slug ? $q->whereHas('category', fn($c) => $c->where('slug', $slug)) : $q;
    }
}
