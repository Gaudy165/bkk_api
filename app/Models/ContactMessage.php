<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'message', 'status', 'read_at'];
    protected $casts = ['read_at' => 'datetime'];

    // Cari nama, email, telp, isi pesan
    public function scopeSearch($q, ?string $term) // $q = query builder, $term = search term
    {
        // fn = function, $qq = sub query builder
        return $term ? $q->where(fn($qq) => $qq
            ->where('name', 'like', "%{$term}%")
            ->orWhere('email', 'like', "%{$term}%")
            ->orWhere('phone', 'like', "%{$term}%")
            ->orWhere('message', 'like', "%{$term}%")
        ) : $q;
    }

    // Filter status: unread|read
    public function scopeStatus($q, ?string $status)
    {
        return $status ? $q->where('status', $status) : $q;
    }
}
