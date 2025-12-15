<x-layouts.app :title="__('Agents n8n')">
    {{-- <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Agents n8n') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Gérer les agents') }}
        </flux:subheading>
        <flux:separator variant="subtle" />
    </div> --}}
    <livewire:agents />
    @if (request()->routeIs('agents'))
        <livewire:card-one />
    @elseif (request()->routeIs('francetravail'))
        <livewire:france-travail />
    @elseif (request()->routeIs('indeed'))
        <livewire:indeed />
    @endif
</x-layouts.app>
