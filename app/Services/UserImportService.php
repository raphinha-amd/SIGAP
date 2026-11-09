<?php

namespace App\Services;

use App\Imports\UserRowsImport;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Excel as ExcelType;
use Maatwebsite\Excel\Facades\Excel;

class UserImportService
{
    public function import(string $path): UserImportResult
    {
        $import = new UserRowsImport;
        $readerType = match (mb_strtolower(pathinfo($path, PATHINFO_EXTENSION))) {
            'csv', 'txt' => ExcelType::CSV,
            'xlsx' => ExcelType::XLSX,
            default => null,
        };

        Excel::import($import, $path, null, $readerType);

        $errors = [];
        $imported = 0;
        $seen = [
            'email' => [],
            'nik' => [],
            'no_telp' => [],
        ];
        $rows = $import->rows ?? collect();

        foreach ($rows as $index => $row) {
            $line = $index + 2;
            $data = $this->normalizeRow($row->toArray());

            if ($this->isEmpty($data)) {
                continue;
            }

            $validator = Validator::make($data, [
                'nama' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
                'password' => ['required', 'string', 'min:8', 'max:255'],
                'role' => ['required', Rule::in(['petugas', 'masyarakat'])],
                'nik' => ['required', 'digits_between:1,16', Rule::unique('users', 'nik')],
                'no_telp' => ['required', 'digits_between:1,20', Rule::unique('users', 'no_telp')],
            ]);

            foreach (['email', 'nik', 'no_telp'] as $uniqueField) {
                if (isset($seen[$uniqueField][$data[$uniqueField]])) {
                    $validator->errors()->add($uniqueField, 'Nilai duplikat di dalam file.');
                }
            }

            if ($validator->fails()) {
                $errors[$line] = implode(' ', $validator->errors()->all());

                continue;
            }

            try {
                DB::transaction(function () use ($data): void {
                    User::create([
                        'name' => $data['nama'],
                        'email' => $data['email'],
                        'password' => Hash::make($data['password']),
                        'role' => $data['role'],
                        'nik' => $data['nik'],
                        'no_telp' => $data['no_telp'],
                        'status_akun' => true,
                    ]);
                });

                $imported++;
                $seen['email'][$data['email']] = true;
                $seen['nik'][$data['nik']] = true;
                $seen['no_telp'][$data['no_telp']] = true;
            } catch (QueryException $exception) {
                report($exception);
                $errors[$line] = 'Data gagal disimpan karena terjadi konflik atau kesalahan database.';
            }
        }

        return new UserImportResult($rows->count(), $imported, $errors);
    }

    /**
     * @param  array<string, mixed>  $row
     * @return array<string, string>
     */
    private function normalizeRow(array $row): array
    {
        return [
            'nama' => trim((string) ($row['nama'] ?? '')),
            'email' => mb_strtolower(trim((string) ($row['email'] ?? ''))),
            'password' => trim((string) ($row['password'] ?? '')),
            'role' => mb_strtolower(trim((string) ($row['role'] ?? ''))),
            'nik' => trim((string) ($row['nik'] ?? '')),
            'no_telp' => trim((string) ($row['no_telp'] ?? '')),
        ];
    }

    /**
     * @param  array<string, string>  $data
     */
    private function isEmpty(array $data): bool
    {
        return collect($data)->every(fn (string $value): bool => $value === '');
    }
}
