<x-layouts.app :title="__('Gestion des liens France Travail')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Liens France Travail') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Gérer les liens France Travail de l\'application') }}
        </flux:subheading>
        <flux:separator variant="subtle" />
        <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600" style="color: seagreen">
            <flux:button variant="danger" color="red" :href="route('francetravail')">
                Retour
            </flux:button>
        </td>
        {{-- <flux:select label="Filtrer par statut" wire:model="statusFilter"
            class="mt-4 border border-neutral-300 px-4 py-2 dark:border-neutral-600">
            <flux:select.option value="all">{{ __('Tous les statuts') }}</flux:select.option>
            <flux:select.option value="1">{{ __('Actif') }}</flux:select.option>
            <flux:select.option value="0">{{ __('Inactif') }}</flux:select.option>
        </flux:select> --}}
    </div>

    <livewire:links-francetravail />
</x-layouts.app>
