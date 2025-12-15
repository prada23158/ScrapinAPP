<div class="border-b border-gray-200 dark:border-gray-700 mb-6 pb-4 bg-white dark:bg-gray-800 rounded-lg">
    <flux:navbar scrollable>
        <flux:navbar.item :href="route('agents')" :current="request()->routeIs('agents')" wire:navigate>
            {{ __('Tous les Agents') }}</flux:navbar.item>
        <flux:navbar.item badge="6" :href="route('francetravail')" :current="request()->routeIs('francetravail')"
            wire:navigate>
            {{ __('France Travail') }}</flux:navbar.item>
        <flux:navbar.item badge="6" :href="route('indeed')" :current="request()->routeIs('indeed')" wire:navigate>
            {{ __('Indeed') }}</flux:navbar.item>
        {{-- <flux:navbar.item :href="route('indeed')" :current="request()->routeIs('indeed')" wire:navigate>
            {{ __('Indeed') }}</flux:navbar.item> --}}
        {{-- <flux:navbar.item href="#">Configuration</flux:navbar.item> --}}
    </flux:navbar>
</div>
