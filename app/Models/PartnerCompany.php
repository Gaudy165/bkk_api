<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerCompany extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'logo_path', 'industry', 'status', 'partnership_date', 'website', 'description'];
    protected $casts = ['partnership_date' => 'date'];

    // Cari nama, bidang/industri, website, deskripsi
    public function scopeSearch($q, ?string $term) // $q = query builder, $term = search term
    {
        // fn = function, $qq = sub query builder
        return $term ? $q->where(fn($qq) =>$qq
            ->where('name', 'like', "%{$term}")
            ->orWhere('industry', 'like', "%{$term}%")
            ->orWhere('website', 'like', "%{$term}%")
            ->orWhere('description', 'like', "%{$term}%")
        ) : $q;
    }

    // Filter status: active|inactive
    public function scopeStatus($q, ?string $status)
    {
        return $status ? $q->where('status', $status) : $q;
    }
}
