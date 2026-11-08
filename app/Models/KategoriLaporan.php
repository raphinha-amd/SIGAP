<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;

#[Guarded(['id'])]
class KategoriLaporan extends Model
{
    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'kategori_laporan_id');
    }
}
