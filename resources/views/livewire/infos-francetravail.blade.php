<flux:modal name="infos-francetravail" class="min-w-[96rem]">
    {{-- <p>composant: {{ get_class($this) }}</p> --}}
    <div class="space-y-6">
        @if (!$this->success)
            <div class="mt-8 p-4 rounded">
                <flux:badge variant='solid' color='red'>
                    {{ __('Code d\'erreur') }} : {{ $errorCode }}
                </flux:badge>
                @if (in_array($this->status, ['error', 'failed']))
                    <flux:text class="mt-2 text-red-600 font-semibold">
                        {{ __('ERREUR') }}
                    </flux:text>
                @endif

                <div class="flex justify-center items-center">
                    <img src="error.png" alt="" class="w-16 h-16 mt-4">
                </div>

                <flux:text class="mt-2">
                    <strong>{{ __('Message :') }}
                        {{ $this->$errorMessage ?? __('Le workflow précédent a été annulé.') }}</strong>
                </flux:text>

                @if ($this->errorHint)
                    <flux:text class="mt-2 text-sm">
                        <strong>{{ __('Hint :') }} {{ $this->errorHint }}</strong>
                    </flux:text>
                @endif
            </div>
        @elseif (!$this->success && in_array($this->status, ['canceled']))
            <div class="mt-8 p-4 rounded">
                <flux:badge variant='solid' color='yellow'>
                    {{ __('Le workflow précédent a été annulé.') }}
                </flux:badge>
                <div class="flex justify-center items-center">
                    <img src="warning.png" alt="" class="w-16 h-16 mt-4">

                    <flux:text class="mt-2">
                        {{ __('Patientez le workflow est en cours...') }}
                    </flux:text>
                </div>
                @if ($data > 0)
                    <div class="mt-4 p-4 rounded bg-gray-100" wire:poll.5s="refreshCount">

                        {{-- Offres trouvées --}}
                        <h3 class="text-lg font-medium mb-2">
                            {{ __('Nombre d\'offres trouvées: ') }} {{ $data }}
                        </h3>

                        {{-- offres scrappés --}}
                        @if ($linksScrapped > 0)
                            <h3 class="text-lg font-medium mb-2">
                                {{ __('Nombre de liens scrappés: ') }} {{ $linksScrapped }}
                            </h3>
                        @endif

                        {{-- liens non scrappés ou offres restantes --}}
                        @if ($linksNotScrapped > 0)
                            <h3 class="text-lg font-medium mb-2">
                                {{ __('Nombre de liens restants: ') }} {{ $linksNotScrapped }}
                            </h3>
                        @endif
                    </div>
                @else
                    <div class="mt-4 p-4 rounded">
                        <flux:text class="mt-2">
                            {{ __('Aucune offre enregistrée.') }}
                        </flux:text>
                    </div>
                @endif
            </div>
        @elseif ($this->success && $this->status === 'success' && $this->finished)
            <div class="mt-8 p-4 rounded">
                <flux:badge variant='solid' color='green'>
                    {{ __('Terminé avec succès') }}
                </flux:badge>
                <flux:text class="mt-2">
                    {{ __('Terminé avec succès') }}
                </flux:text>


                <div class="flex justify-center items-center">
                    <img src="success.png" alt="Success" class="w-16 h-16 mt-4 sm:h-32 sm:w-32">
                </div>
                @if ($data > 0)
                    <div class="mt-4 p-4 rounded bg-gray-100" wire:poll.5s="refreshCount">

                        {{-- Offres trouvées --}}
                        <h3 class="text-lg font-medium mb-2">
                            {{ __('Nombre d\'offres trouvées: ') }} {{ $data }}
                        </h3>

                        {{-- offres scrappés --}}
                        @if ($linksScrapped > 0)
                            <h3 class="text-lg font-medium mb-2">
                                {{ __('Nombre de liens scrappés: ') }} {{ $linksScrapped }}
                            </h3>
                        @endif

                        {{-- liens non scrappés ou offres restantes --}}
                        @if ($linksNotScrapped > 0)
                            <h3 class="text-lg font-medium mb-2">
                                {{ __('Nombre de liens restants: ') }} {{ $linksNotScrapped }}
                            </h3>
                        @endif
                    </div>
                @else
                    <div class="mt-4 p-4 rounded">
                        <flux:text class="mt-2">
                            {{ __('Aucune offre enregistrée.') }}
                        </flux:text>
                    </div>
                @endif
            </div>
        @elseif ($this->success && in_array($this->status, ['running', 'waiting']))
            <div class="mt-8 p-4 rounded bg-blue-50 border border-blue-200">
                <flux:badge variant='solid' color='blue'>
                    {{ __('En cours...') }} : {{ ucfirst($this->status) }}
                </flux:badge>
                <flux:text class="mt-2">
                    {{ __('Le workflow est en cours d\'exécution') }}
                </flux:text>
                {{-- <p class="mt-2">ID: {{ $executionId }}</p> --}}
                {{-- succes: {{ $success }} --}}
            </div>
            @if ($data > 0)
                <div class="mt-4 p-4 rounded bg-gray-100" wire:poll.5s="refreshCount">
                    {{-- offres scrappés ou liens scrappés --}}
                    @if ($linksScrapped > 0)
                        <h3 class="text-lg font-medium mb-2">
                            {{ __('Nombre de liens scrappés: ') }} {{ $linksScrapped }}
                        </h3>
                    @endif

                    {{-- Offres trouvées --}}
                    <h3 class="text-lg font-medium mb-2">
                        {{ __('Nombre d\'offres trouvées: ') }} {{ $data }}
                    </h3>

                    {{-- liens non scrappés ou offres restantes --}}
                    @if ($linksNotScrapped > 0)
                        <h3 class="text-lg font-medium mb-2">
                            {{ __('Nombre de liens restants: ') }} {{ $linksNotScrapped }}
                        </h3>
                    @endif
                </div>
            @else
                <div class="mt-4 p-4 rounded">
                    <flux:text class="mt-2">
                        {{ __('Aucune offre enregistrée') }}
                    </flux:text>
                </div>
            @endif
        @endif
    </div>
</flux:modal>
