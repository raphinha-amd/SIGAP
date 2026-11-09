<?php

namespace Tests\Feature;

use App\Exports\UsersExport;
use App\Exports\UserTemplateExport;
use App\Models\User;
use App\Services\UserImportService;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Maatwebsite\Excel\Excel as ExcelType;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class UserImportExportTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_valid_csv_import_creates_users_with_hashed_passwords(): void
    {
        $path = $this->writeCsv([
            ['nama', 'email', 'password', 'role', 'nik', 'no_telp'],
            ['Petugas Import', 'petugas.import@example.com', 'Password123', 'petugas', '3272000000000101', '081200000101'],
        ]);

        $result = app(UserImportService::class)->import($path);

        $this->assertSame(1, $result->imported);
        $this->assertSame(0, $result->failed());
        $this->assertDatabaseHas('users', [
            'email' => 'petugas.import@example.com',
            'role' => 'petugas',
        ]);
        $this->assertTrue(password_verify('Password123', User::query()->where('email', 'petugas.import@example.com')->value('password')));

        unlink($path);
    }

    public function test_import_rejects_admin_role_and_duplicate_values_per_row(): void
    {
        $existing = [
            'name' => 'Existing User',
            'email' => 'existing@example.com',
            'password' => 'password',
            'role' => 'masyarakat',
            'nik' => '3272000000000102',
            'no_telp' => '081200000102',
        ];
        User::query()->create($existing);

        $path = $this->writeCsv([
            ['nama', 'email', 'password', 'role', 'nik', 'no_telp'],
            ['Admin Import', 'admin.import@example.com', 'Password123', 'admin', '3272000000000103', '081200000103'],
            ['Duplicate Import', 'existing@example.com', 'Password123', 'petugas', '3272000000000104', '081200000104'],
        ]);

        $result = app(UserImportService::class)->import($path);

        $this->assertSame(0, $result->imported);
        $this->assertSame(2, $result->failed());
        $this->assertArrayHasKey(2, $result->errors);
        $this->assertArrayHasKey(3, $result->errors);
        $this->assertDatabaseMissing('users', ['email' => 'admin.import@example.com']);

        unlink($path);
    }

    public function test_export_and_template_do_not_include_passwords(): void
    {
        $user = User::query()->create([
            'name' => 'Export User',
            'email' => 'export@example.com',
            'password' => 'password',
            'role' => 'petugas',
            'nik' => '3272000000000105',
            'no_telp' => '081200000105',
        ]);

        $csv = Excel::raw(new UsersExport(User::query()->get()), ExcelType::CSV);
        $template = Excel::raw(new UserTemplateExport, ExcelType::XLSX);

        $this->assertStringContainsString('"name","email","role","created_at"', $csv);
        $this->assertStringContainsString('Petugas', $csv);
        $this->assertStringNotContainsString('password', $csv);
        $this->assertNotEmpty($template);
        $this->assertNotEmpty($user->created_at);
    }

    /**
     * @param  array<int, array<int, string>>  $rows
     */
    private function writeCsv(array $rows): string
    {
        $path = tempnam(sys_get_temp_dir(), 'sigap-users-');
        unlink($path);
        $path .= '.csv';
        $handle = fopen($path, 'wb');

        foreach ($rows as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);

        return $path;
    }
}
