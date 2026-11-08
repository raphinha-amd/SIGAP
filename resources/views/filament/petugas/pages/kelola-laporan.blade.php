<x-filament-panels::page>
    <x-filament::breadcrumbs :breadcrumbs="[
        '/petugas/manage-laporan' => 'Kelola Laporan Masyarakat',
        url()->current() => 'Detail Laporan Masyarakat',
    ]" />
    {{ $this->content }}

    <x-filament::section>
        <x-slot name="heading">
            Riwayat Tindak Lanjut
        </x-slot>

        <x-slot name="description">
            Daftar aktivitas penanganan laporan oleh petugas desa.
        </x-slot>

        {{ $this->table }}
    </x-filament::section>
</x-filament-panels::page>
