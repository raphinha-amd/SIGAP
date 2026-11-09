<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UserTemplateDataSheet implements FromArray, WithEvents, WithHeadings, WithStyles, WithTitle
{
    public function array(): array
    {
        return [
            [
                'Budi Contoh',
                'budi.contoh@example.com',
                'PasswordContoh123',
                'masyarakat',
                '3272000000000001',
                '081200000001',
            ],
        ];
    }

    public function headings(): array
    {
        return ['nama', 'email', 'password', 'role', 'nik', 'no_telp'];
    }

    public function title(): string
    {
        return 'Data User';
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => '2563EB'],
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event): void {
                $sheet = $event->sheet->getDelegate();
                $sheet->freezePane('A2');
                $sheet->setAutoFilter('A1:F1');
                $sheet->getStyle('A1:F1')->getAlignment()->setHorizontal('center');
                $sheet->getColumnDimension('A')->setWidth(24);
                $sheet->getColumnDimension('B')->setWidth(34);
                $sheet->getColumnDimension('C')->setWidth(24);
                $sheet->getColumnDimension('D')->setWidth(16);
                $sheet->getColumnDimension('E')->setWidth(20);
                $sheet->getColumnDimension('F')->setWidth(18);

                $validation = new DataValidation;
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_STOP);
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setErrorTitle('Role tidak valid');
                $validation->setError('Pilih petugas atau masyarakat.');
                $validation->setPromptTitle('Role');
                $validation->setPrompt('Pilih petugas atau masyarakat.');
                $validation->setFormula1('"petugas,masyarakat"');

                for ($row = 2; $row <= 1000; $row++) {
                    $sheet->getCell("D{$row}")->setDataValidation(clone $validation);
                }
            },
        ];
    }
}
