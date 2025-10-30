<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Gallery extends Model
{
    public function scopeSearch($q, $s)
    {
        return $s ? $q->where(fn($qq) => $qq
            ->where('description', 'like', "%$s%")) : $q;
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
