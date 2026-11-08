<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Guarded(['id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return match ($panel->getId()) {
            'admin' => $this->role === 'admin',
            'petugas' => $this->role === 'petugas',
            'masyarakat' => $this->role === 'masyarakat',
            default => false,
        };
    }

    public function aspirasi()
    {
        return $this->hasMany(Aspirasi::class, 'user_id');
    }

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'user_id');
    }

    public function tindakLanjut()
    {
        return $this->hasMany(TindakLanjut::class, 'user_id');
    }

    public function balasanAspirasi()
    {
        return $this->hasMany(BalasanAspirasi::class, 'user_id');
    }
}
