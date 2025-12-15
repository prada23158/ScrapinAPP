<div class="size-40">
    <livewire:agents />
    <livewire:nav-agents />
    <livewire:francetravail-modal />
    {{-- composant livewire pour afficher les liens France Travail  --}}
    {{-- <livewire:links-francetravail /> --}}
    @if (session()->has('message'))
        <div class="alert alert-success" role="alert">
            {{ session('message') }}
        </div>
    @elseif (session()->has('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif
    {{-- Metrics Grid --}}
    <div class="px-6 pb-12 sm:px-6 lg:px-4">
        <div class="w-32 mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Step One --}}
                <div
                    class="bg-white dark:bg-zinc-700 hover:bg-indigo-100 dark:hover:bg-neutral-700 rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-start justify-between mb-4">
                        <div class="bg-white rounded-xl p-3">
                            <img src="google.png" alt="">
                        </div>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-gray-900">
                        </span>
                    </div>
                    <h3 class="text-gray-600 text-sm font-medium mb-2">Offres France Travail sur google</h3>
                    <p class="text-3xl font-bold text-gray-900">Collecte des liens liés aux mots clés</p>
                    <flux:modal.trigger name="modal-francetravail">
                        <flux:button variant="primary" color="cyan" class="mt-4 w-full"
                            wire:click="stepOneFrancetravailWorkflow">
                            Activer
                        </flux:button>
                    </flux:modal.trigger>

                    <flux:button variant="primary" :href="route('liens-francetravail')" color="cyan"
                        class="mt-4 w-full">
                        Voir les liens Scrappés
                    </flux:button>
                </div>

                {{-- Step Two --}}
                <div
                    class="bg-white dark:bg-zinc-700 hover:bg-indigo-100 dark:hover:bg-neutral-700 rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-start justify-between mb-4">
                        <div class="bg-white rounded-xl p-3">
                            <img src="francetravail.jpeg" alt="">
                        </div>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-gray-900">
                            France Travail
                        </span>
                    </div>
                    <h3 class="text-gray-600 text-sm font-medium mb-2">Les infos des Offres</h3>
                    <p class="text-3xl font-bold text-gray-900">Collecte des informations</p>
                    <flux:modal.trigger name="modal-francetravail">
                        <flux:button variant="primary" color="cyan" class="mt-4 w-full"
                            wire:click="stepTwoFrancetravailWorkflow">
                            Activer
                        </flux:button>
                    </flux:modal.trigger>

                    <flux:button variant="primary" :href="route('offres-francetravail')" color="cyan"
                        class="mt-4 w-full">
                        Voir les informations </flux:button>

                </div>

                {{-- Step Three --}}
                <div
                    class="bg-white dark:bg-zinc-700 hover:bg-indigo-100 dark:hover:bg-neutral-700 rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-start justify-between mb-4">
                        <div class="bg-white rounded-xl p-3">
                            <img src="google.png" alt="">
                        </div>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-gray-900">
                            France Travail
                        </span>
                    </div>
                    <h3 class="text-gray-600 text-sm font-medium mb-2">Les infos des Entreprise</h3>
                    <p class="text-3xl font-bold text-gray-900">Collecte des infos des entreprises</p>
                    <flux:modal.trigger name="modal-francetravail">
                        <flux:button variant="primary" color="cyan" class="mt-4 w-full"
                            wire:click="stepThreeFrancetravailWorkflow">
                            Activer
                        </flux:button>
                    </flux:modal.trigger>

                    <flux:button variant="primary" :href="route('infos-ft')" color="cyan" class="mt-4 w-full">
                        Voir les informations </flux:button>

                </div>

                {{-- Step Four --}}
                <div
                    class="bg-white dark:bg-zinc-700 hover:bg-indigo-100 dark:hover:bg-neutral-700 rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-start justify-between mb-4">
                        <div class="bg-white rounded-xl p-3">
                            <img src="google.png" alt="">
                        </div>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-gray-900">
                            France Travail
                        </span>
                    </div>
                    <h3 class="text-gray-600 text-sm font-medium mb-2">Les Contacts des Entreprises</h3>
                    <p class="text-3xl font-bold text-gray-900"></p>
                    <flux:modal.trigger name="modal-francetravail">
                        <flux:button variant="primary" color="cyan" class="mt-4 w-full"
                            wire:click="stepFourFrancetravailWorkflow">
                            Activer
                        </flux:button>
                    </flux:modal.trigger>

                    <flux:button variant="primary" :href="route('contacts-ft')" color="cyan" class="mt-4 w-full">
                        Voir les informations </flux:button>
                </div>

                {{-- Step Five --}}
                <div
                    class="bg-white dark:bg-zinc-700 hover:bg-indigo-100 dark:hover:bg-neutral-700 rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-start justify-between mb-4">
                        <div class="bg-white rounded-xl p-3">
                            <img src="maps.jpg" alt="">
                        </div>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-gray-900">
                            France Travail
                        </span>
                    </div>
                    <h3 class="text-gray-600 text-sm font-medium mb-2">Les numéros</h3>
                    <p class="text-3xl font-bold text-gray-900"></p>
                    <flux:modal.trigger name="modal-francetravail">
                        <flux:button variant="primary" color="cyan" class="mt-4 w-full"
                            wire:click="stepTelFrancetravailWorkflow">
                            Activer
                        </flux:button>
                    </flux:modal.trigger>

                    <flux:button variant="primary" :href="route('numeros-francetravail')" color="cyan"
                        class="mt-4 w-full">
                        Voir les informations </flux:button>
                </div>

                {{-- Saint Graal --}}
                <div
                    class="bg-white dark:bg-zinc-700 hover:bg-indigo-100 dark:hover:bg-neutral-700 rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-start justify-between mb-4">
                        <div class="bg-white rounded-xl p-3">
                            <img src="resultats.png" alt="">
                        </div>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-gray-900">
                            France Travail
                        </span>
                    </div>
                    <h3 class="text-gray-600 text-sm font-medium mb-2">Le Saint Graal</h3>
                    <p class="text-3xl font-bold text-gray-900">France Travail</p>
                    {{-- <flux:modal.trigger name="modal-francetravail">
                        <flux:button variant="primary" color="cyan" class="mt-4 w-full"
                            wire:click="stepGraalFrancetravailWorkflow">
                            Activer
                        </flux:button>
                    </flux:modal.trigger> --}}
                    {{-- bouton export  --}}
                    {{-- <p>Composant: {{ get_class($this) }}</p> voir quel composant est utilisé --}}
                    <flux:button wire:click="export" icon="arrow-down-tray">Export</flux:button>

                    <flux:button variant="primary" :href="route('saintgraal-francetravail')" color="cyan"
                        class="mt-4 w-full">
                        Voir les informations </flux:button>
                </div>
            </div>
        </div>
    </div>
</div>
