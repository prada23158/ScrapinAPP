<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        <livewire:metric />
        <livewire:activites />
        {{-- <livewire:graphique /> --}}
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:bg-gray-800">
            <x-placeholder-pattern class="absolute inset-0 size-full dark:stroke-neutral-100/20" />
            <div>
                <div class="text-xl font-medium text-black dark:text-white">ChitChat</div>
                <span class="text-gray-500 dark:text-gray-400">You have a new message!</span>
            </div>
        </div>
    </div>
</x-layouts.app>
