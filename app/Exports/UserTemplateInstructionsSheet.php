<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UserTemplateInstructionsSheet implements FromArray, WithEvents, WithStyles, WithTitle
{
    public function array(): array
    {
        return [
            ['Petunjuk Pengisian Template User SIGAP'],
            ['1. Isi satu akun pada setiap baris di sheet Data User.'],
            ['2. Semua kolom wajib diisi: nama, email, password, role, nik, dan no_telp.'],
            ['3. Password minimal 8 karakter dan akan di-hash sebelum disimpan.'],
            ['4. Role hanya boleh petugas atau masyarakat. Role admin tidak dapat diimpor.'],
            ['5. Email, NIK, dan nomor telepon harus unik.'],
            ['6. Hapus baris contoh sebelum mengimpor jika tidak diperlukan.'],
        ];
    }

    public function title(): string
    {
        return 'Petunjuk';
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event): void {
                $sheet = $event->sheet->getDelegate();
                $sheet->getColumnDimension('A')->setWidth(110);
                $sheet->getStyle('A1:A7')->getAlignment()->setWrapText(true);
            },
        ];
    }
}
