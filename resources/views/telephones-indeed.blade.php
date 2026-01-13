<x-layouts.app :title="__('Téléphones Indeed')">
    <div class="relative mb-6 w-full">
        <flux:button variant="danger" color="red" :href="route('indeed')">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-move-left-icon lucide-move-left">
                <path d="M6 8L2 12L6 16" />
                <path d="M2 12H22" />
            </svg>Retour
        </flux:button>
        {{-- <flux:heading size="xl" level="1">{{ __('') }}</flux:heading> --}}
        <flux:subheading size="lg" class="mb-6">
            {{ __('Gérer les téléphones Indeed de l\'application') }}
        </flux:subheading>
        {{-- <flux:separator variant="subtle" /> --}}
    </div>

    {{-- composant des telephones Indeed sur les entreprises --}}
    <livewire:numeros-indeed />
</x-layouts.app>
