<x-filament-panels::page>
    <form wire:submit="save" class="space-y-6 max-w-4xl">
        {{ $this->form }}

        <x-filament::button type="submit">
            Simpan Setting PWA
        </x-filament::button>
    </form>
</x-filament-panels::page>
