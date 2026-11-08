<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;

#[Guarded(['id'])]
class Aspirasi extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function balasanAspirasi()
    {
        return $this->hasMany(BalasanAspirasi::class, 'aspirasi_id');
    }
}
