<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;

#[Guarded(['id'])]
class FotoLaporan extends Model
{
    public function laporan()
    {
        return $this->belongsTo(Laporan::class, 'laporan_id');
    }
}
