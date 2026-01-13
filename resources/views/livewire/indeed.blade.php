<div class="size-40">
    <livewire:agents />
    <livewire:nav-agents />
    <livewire:modal-indeed />
    {{-- composant livewire pour afficher les liens Indeed  --}}
    {{-- <livewire:links-indeed /> --}}
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
                    <p class="text-3xl font-bold text-gray-900">Avec Apify</p>

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
                    <flux:modal.trigger name="modal-indeed">
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
                    <flux:modal.trigger name="modal-indeed">
                        <flux:button variant="primary" color="cyan" class="mt-4 w-full"
                            wire:click="StepContactIndeedWorkflow">
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
                    <flux:modal.trigger name="modal-indeed">
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
