<x-layouts.app :title="__('Nos Mots-clés Indeed')">
    <div class="relative mb-6 w-full">
        <flux:heading size='xl' level="1">
            {{ __('Gestion des Mots-clés Indeed') }}
        </flux:heading>
        <flux:subheading size="lg" class="mb-6">
            {{ __('Gestion des Mots-clés Indeed') }}
        </flux:subheading>
    </div>
    <flux:separator variant="subtle" />
    <livewire:keywords-indeed />
    <livewire:keyword-edit />
</x-layouts.app>
