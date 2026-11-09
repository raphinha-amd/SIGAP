<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(private readonly Collection $users) {}

    public function collection(): Collection
    {
        return $this->users;
    }

    public function headings(): array
    {
        return ['name', 'email', 'role', 'created_at'];
    }

    /**
     * @param  User  $user
     */
    public function map($user): array
    {
        return [
            $user->name,
            $user->email,
            match ($user->role) {
                'admin' => 'Admin',
                'petugas' => 'Petugas',
                'masyarakat' => 'Masyarakat',
                default => $user->role,
            },
            $user->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
