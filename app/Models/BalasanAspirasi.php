<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;

#[Guarded(['id'])]
class BalasanAspirasi extends Model
{
    public function aspirasi()
    {
        return $this->belongsTo(Aspirasi::class, 'aspirasi_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
