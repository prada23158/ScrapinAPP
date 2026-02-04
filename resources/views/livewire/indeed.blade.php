<div class="size-40">
    <livewire:agents />
    <livewire:nav-agents />
    {{-- Composant livewire modal des offres indeed --}}
    <livewire:modal-indeed />
    {{-- composant livewire du statut les infos entreprises Indeed  --}}
    <livewire:entreprises-indeed />
    {{-- composant livewire du statut les prospects Indeed  --}}
    <livewire:prospects-indeed />
    {{-- composant livewire du statut les téléphones Indeed  --}}
    <livewire:telephones-indeed />
    {{-- composant livewire pour la suppression des doublons --}}
    <livewire:doublonsoffres-indeed />
    {{-- Metrics Grid --}}
    <div class="px-6 pb-12 sm:px-6 lg:px-4">
        <div class="w-32 mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Revenu Total --}}
                <div
                    class="bg-white dark:bg-zinc-700 hover:bg-indigo-100 dark:hover:bg-neutral-700 rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-start justify-between mb-4">
                        <div class="bg-white rounded-xl p-3">
                            <img src="apify.png" alt="">
                        </div>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            Indeed
                        </span>
                    </div>
                    <h3 class="text-gray-600 text-sm font-medium mb-2">Offres Indeed sur Apify</h3>
                    <flux:modal.trigger name="modal-indeed">
                        <flux:button variant="primary" color="cyan" class="mt-4 w-full"
                            wire:click="stepOneIndeedWorkflow">
                            Activer
                        </flux:button>
                    </flux:modal.trigger>
                    {{-- <p>Composant: {{ get_class($this) }}</p> --}}
                    <flux:button variant="primary" :href="route('offres-indeed')" color="cyan" class="mt-4 w-full">
                        Voir les offres Apify
                    </flux:button>
                    <div wire:poll.5s="compterDoublons">
                        @if ($countDoublons > 0)
                            <div class="mt-4" x-data="{ show: true }" x-show="show" x-transition>
                                <div class="mb-2 flex items-center justify-between">
                                    <flux:badge variant='solid' color='orange' class="animate-pulse">
                                        ⚠️ {{ $countDoublons }} doublon(s) détecté(s)
                                    </flux:badge>
                                </div>
                                <flux:modal.trigger name="doublonsoffres-indeed">
                                    <flux:button variant="primary" color="red" class="mt-4 w-full"
                                        wire:click="$dispatch('start-suppression')">
                                        Supprimer les {{ $countDoublons }} doublons
                                    </flux:button>
                                </flux:modal.trigger>
                            </div>
                        @else
                            <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                                <div class="flex items-center gap-2 text-green-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-medium">Aucun doublon détecté</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Informations des entreprises --}}
                <div
                    class="bg-white dark:bg-zinc-700 hover:bg-indigo-100 dark:hover:bg-neutral-700 rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-start justify-between mb-4">
                        <div class="bg-white rounded-xl p-3">
                            <img src="google.png" alt="">
                        </div>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            Indeed
                        </span>
                    </div>
                    <h3 class="text-gray-600 text-sm font-medium mb-2">Les infos des entreprises</h3>
                    <p class="text-3xl font-bold text-gray-900"></p>
                    <flux:modal.trigger name="entreprises-indeed">
                        <flux:button variant="primary" color="cyan" class="mt-4 w-full"
                            wire:click="StepInfoIndeedWorkflow">
                            Activer
                        </flux:button>
                    </flux:modal.trigger>
                    <flux:button variant="primary" :href="route('infos-indeed')" color="cyan" class="mt-4 w-full">
                        Voir les informations
                    </flux:button>
                </div>

                {{-- Infos 
                <div
                    class="bg-white dark:bg-zinc-700 hover:bg-indigo-100 dark:hover:bg-neutral-700 rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-start justify-between mb-4">
                        <div class="bg-white rounded-xl p-3">
                            <img src="google.png" alt="">
                        </div>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            Indeed
                        </span>
                    </div>
                    <h3 class="text-gray-600 text-sm font-medium mb-2">Les infos des Entreprise</h3>
                    <p class="text-3xl font-bold text-gray-900"></p>

                </div>

                {{-- Contacts --}}
                <div
                    class="bg-white dark:bg-zinc-700 hover:bg-indigo-100 dark:hover:bg-neutral-700 rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-start justify-between mb-4">
                        <div class="bg-white rounded-xl p-3">
                            <img src="linkedin.png" alt="">
                        </div>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            Indeed
                        </span>
                    </div>
                    <h3 class="text-gray-600 text-sm font-medium mb-2">Les Contacts des Entreprises</h3>
                    <p class="text-3xl font-bold text-gray-900"></p>
                    <flux:modal.trigger name="prospects-indeed">
                        <flux:button variant="primary" color="cyan" class="mt-4 w-full"
                            wire:click="StepProspectIndeedWorkflow">
                            Activer
                        </flux:button>
                    </flux:modal.trigger>
                    <flux:button variant="primary" :href="route('contacts-indeed')" color="cyan" class="mt-4 w-full">
                        Voir les informations
                    </flux:button>

                </div>

                {{-- Numéros --}}
                <div
                    class="bg-white dark:bg-zinc-700 hover:bg-indigo-100 dark:hover:bg-neutral-700 rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-start justify-between mb-4">
                        <div class="bg-white rounded-xl p-3">
                            <img src="maps.jpg" alt="">
                        </div>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            Indeed
                        </span>
                    </div>
                    <h3 class="text-gray-600 text-sm font-medium mb-2">Les numéros</h3>
                    <p class="text-3xl font-bold text-gray-900"></p>
                    <flux:modal.trigger name="telephones-indeed">
                        <flux:button variant="primary" color="cyan" class="mt-4 w-full"
                            wire:click="StepTelIndeedWorkflow">
                            Activer
                        </flux:button>
                    </flux:modal.trigger>
                    <flux:button variant="primary" :href="route('telephones-indeed')" color="cyan"
                        class="mt-4 w-full">
                        Voir les informations
                    </flux:button>
                </div>

                {{-- Résultats --}}
                <div
                    class="bg-white dark:bg-zinc-700 hover:bg-indigo-100 dark:hover:bg-neutral-700 rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-start justify-between mb-4">
                        <div class="bg-white rounded-xl p-3">
                            <img src="resultats.png" alt="">
                        </div>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            Indeed
                        </span>
                    </div>
                    <h3 class="text-gray-600 text-sm font-medium mb-2">Le Saint Graal</h3>
                    <p class="text-3xl font-bold text-gray-900">Indeed</p>
                    {{-- export en xlsx --}}
                    <flux:button wire:click="export" icon="arrow-down-tray">Export</flux:button>

                    <flux:button variant="primary" :href="route('graal-indeed')" color="cyan" class="mt-4 w-full">
                        Voir les informations
                    </flux:button>
                </div>
            </div>
        </div>
    </div>
</div>
