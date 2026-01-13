<x-layouts.app :title="__('Nos Mots-clés')">
    <div class="relative mb-6 w-full">
        <flux:heading size='xl' level="1">
            {{ __('Gestion des Mots-clés') }}
        </flux:heading>
        <flux:subheading size="lg" class="mb-6">
            {{ __('Gestion des Mots-clés') }}
        </flux:subheading>
    </div>
    <flux:separator variant="subtle" />
    <livewire:keywords />
</x-layouts.app>
