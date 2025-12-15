<x-layouts.app :title="__('Gestion des utilisateurs')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Utilisateurs') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Gérer les utilisateurs de l\'application') }}
        </flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <livewire:users />
</x-layouts.app>
