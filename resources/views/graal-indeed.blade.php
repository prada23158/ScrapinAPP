<x-layouts.app :title="__('GRAAL Indeed')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Informations du GRAAL Indeed') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">
            {{ __('Gérer les informations Indeed de l\'application') }}
        </flux:subheading>
        <flux:separator variant="subtle" />
        <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600" style="color: seagreen">
            <flux:button variant="danger" color="red" :href="route('indeed')">
                Retour
            </flux:button>
        </td>

    </div>

    {{-- composant des informations Indeed sur les entreprises --}}
    <livewire:saint-graal-indeed />
</x-layouts.app>
