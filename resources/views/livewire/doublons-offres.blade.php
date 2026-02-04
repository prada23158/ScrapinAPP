<div>
    <flux:modal name="doublons-offres" class="min-w-[48rem]">
        <div class="mt-8 p-6 rounded">

            {{-- Étape 1 : Comptage des doublons --}}
            @if ($counting)
                <div class="text-center">
                    <flux:badge variant='solid' color='blue' class="mb-6">
                        {{ __('Analyse des doublons en cours...') }}
                    </flux:badge>

                    <div class="flex justify-center">
                        <img src="{{ asset('loading.gif') }}" alt="Analyse" class="w-20 h-20">
                    </div>

                    <p class="mt-4 text-gray-600">
                        Recherche des entreprises en doublon...
                    </p>
                </div>
            @endif

            {{-- Étape 2 : Suppression en cours --}}
            @if ($deleting)
                <div class="text-center">
                    <flux:badge variant='solid' color='orange' class="mb-6">
                        {{ __('Suppression en cours...') }}
                    </flux:badge>

                    <div class="flex justify-center">
                        <img src="{{ asset('loading.gif') }}" alt="Suppression" class="w-32 h-32">
                    </div>

                    <div class="mt-4 space-y-2">
                        <p class="text-gray-700 font-medium">
                            {{ $entreprisesEnDoublon }} entreprise(s) concernée(s)
                        </p>
                        <p class="text-gray-600">
                            Suppression de {{ $nombreTotalDoublons }} doublon(s)...
                        </p>
                    </div>
                </div>
            @endif

            {{-- Étape 3 : Succès --}}
            @if ($finished)
                <div class="text-center">
                    <flux:badge variant='solid' color='green' class="mb-6">
                        {{ __('✓ Suppression terminée avec succès !') }}
                    </flux:badge>

                    {{-- GIF de succès --}}
                    <div class="flex justify-center mb-6">
                        <img src="{{ asset('Validation.gif') }}" alt="Succès" class="w-40 h-40">
                    </div>

                    {{-- Résumé --}}
                    <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center">
                                <p class="text-sm text-gray-600 mb-1">Entreprises concernées</p>
                                <p class="text-3xl font-bold text-green-700">{{ $entreprisesEnDoublon }}</p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-600 mb-1">Doublons supprimés</p>
                                <p class="text-3xl font-bold text-red-600">{{ $doublonsSupprimes }}</p>
                            </div>
                        </div>
                    </div>

                    <flux:button variant="primary" color="green" class="w-full" wire:click="fermerModal">
                        Fermer
                    </flux:button>
                </div>
            @endif
        </div>
    </flux:modal>
</div>
