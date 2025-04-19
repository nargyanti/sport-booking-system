<x-filament-panels::page>
    <div class="space-y-6">
        <h2 class="text-xl font-bold">Generate Tagihan untuk Jadwal: {{ $record->date }}</h2>

        <p>Tagihan akan dibuat otomatis untuk semua pemain yang hadir.</p>

        <x-filament::button wire:click="generate">
            Proses Sekarang
        </x-filament::button>
    </div>
</x-filament-panels::page>
