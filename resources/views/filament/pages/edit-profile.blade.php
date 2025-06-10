<x-filament::page>
    <form wire:submit.prevent="submit">
        {{ $this->form }}
        <x-filament::button type="submit">حفظ</x-filament::button>
    </form>
</x-filament::page>
