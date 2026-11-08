<x-filament-panels::page>
    <x-filament::breadcrumbs :breadcrumbs="[
        '/petugas/manage-aspirasi' => 'Kelola Aspirasi Masyarakat',
        url()->current() => 'Detail Aspirasi Masyarakat',
    ]" />

    {{ $this->content }}

    <x-filament::section>
        <x-slot name="heading">
            Riwayat Balasan
        </x-slot>

        <x-slot name="description">
            Daftar tanggapan petugas terhadap aspirasi masyarakat.
        </x-slot>

        {{ $this->table }}
    </x-filament::section>
</x-filament-panels::page>
