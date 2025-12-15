<x-layouts.app :title="__('Contacts des entreprises France Travail')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Contacts des entreprises France Travail') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">
            {{ __('Gérer les contacts des entreprises France Travail de l\'application') }}
        </flux:subheading>
        <flux:separator variant="subtle" />
        <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600" style="color: seagreen">
            <flux:button variant="danger" color="red" :href="route('francetravail')">
                Retour
            </flux:button>
        </td>

    </div>

    <livewire:contacts-france-travail />
</x-layouts.app>
