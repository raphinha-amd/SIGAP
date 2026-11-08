<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;

#[Guarded(['id'])]
class Laporan extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tindakLanjut()
    {
        return $this->hasMany(TindakLanjut::class, 'laporan_id');
    }

    public function fotoLaporan()
    {
        return $this->hasMany(FotoLaporan::class, 'laporan_id');
    }

    public function kategoriLaporan()
    {
        return $this->belongsTo(KategoriLaporan::class, 'kategori_laporan_id');
    }
}
