<x-layouts.app :title="__('Gestion des Offres Apify pour Indeed')">
    <div class="relative mb-6 w-full">
        <flux:button variant="danger" color="red" :href="route('indeed')" hint="Retourner aux Workflows"
            class="absolute left-0 top-1/2 -translate-y-1/2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-move-left-icon lucide-move-left">
                <path d="M6 8L2 12L6 16" />
                <path d="M2 12H22" />
            </svg>
        </flux:button>
        <flux:heading size="xl" level="1">
            {{ __('Offres Apify Indeed') }}
        </flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __("Gérer les Offres d'Apify") }}
        </flux:subheading>
        <flux:separator variant="subtle" />
        {{-- <flux:separator variant="subtle" class="mt-4" /> --}}

    </div>
    
    <livewire:offres-indeed />
</x-layouts.app>
