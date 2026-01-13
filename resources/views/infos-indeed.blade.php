<x-layouts.app :title="__('Informations Indeed')">
    <div class="relative mb-6 w-full">
        <flux:button variant="danger" color="red" :href="route('indeed')">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-move-left-icon lucide-move-left">
                <path d="M6 8L2 12L6 16" />
                <path d="M2 12H22" />
            </svg>
        </flux:button>
        <flux:heading size="xl" level="1">{{ __('Informations Indeed') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">
            {{ __('Gérer les informations Indeed de l\'application') }}
        </flux:subheading>
        <flux:separator variant="subtle" />
        <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600" style="color: seagreen">

        </td>

    </div>

    {{-- composant des informations Indeed sur les entreprises --}}
    <livewire:infos-indeed />
</x-layouts.app>
