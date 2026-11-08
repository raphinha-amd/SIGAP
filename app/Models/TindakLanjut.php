<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;

#[Guarded(['id'])]
class TindakLanjut extends Model
{
    public function laporan()
    {
        return $this->belongsTo(Laporan::class, 'laporan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
