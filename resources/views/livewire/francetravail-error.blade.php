<flux:modal name="francetravail-error" class="min-w-[96rem]">
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
                    <strong>{{ __('Message') }} :</strong> {{ $this->errorMessage ?? __('Erreur inconnue') }}
                </flux:text>

                @if ($this->errorHint)
                    <flux:text class="mt-2 text-sm">
                        <strong>{{ __('Hint') }} :</strong> {{ $this->errorHint }}
                    </flux:text>
                @endif
            </div>
        @elseif ($this->success && $this->status === 'success' && $this->finished)
            <div class="mt-8 p-4 rounded">
                <flux:badge variant='solid' color='green'>
                    {{ __('Terminé avec succès') }}
                </flux:badge>
                {{-- @if ($this->success && $this->status === 'success' && $this->finished) --}}
                {{-- <flux:text class="mt-2">
                    {{ __('Terminé avec succès') }}
                </flux:text> --}}
                {{-- @endif --}}

                <div class="flex justify-center items-center">
                    <img src="success.png" alt="Success" class="w-16 h-16 mt-4 sm:h-32 sm:w-32">
                </div>

                <flux:text class="mt-2">
                    {{ $response['message'] ?? 'Workflow démarré.' }}
                    <br>
                    {{ __('Veuillez patienter quelques instants avant de recharger la page.') }}
                </flux:text>
                @if ($data > 0)
                    <div class="mt-4 p-4 rounded bg-gray-100" wire:poll.5s="refreshCount">
                        <h3 class="text-lg font-medium mb-2">
                            {{ __('Nombre de liens ajoutés aujourd’hui : ') }} {{ $data }}
                        </h3>
                    </div>
                @else
                    <div class="mt-4 p-4 rounded" wire:poll.5s="refreshCount">
                        <flux:text class="mt-2">
                            {{ __('Aucun lien enregistré aujourd’hui.') }}
                        </flux:text>
                    </div>
                @endif
            </div>
        @elseif ($this->success && in_array($this->status, ['running', 'waiting']))
            <div class="mt-8 p-4 rounded bg-blue-50 border border-blue-200">
                <flux:badge variant='solid' color='blue'>
                    {{ __('En cours...') }}
                </flux:badge>
                <flux:text class="mt-2">
                    {{ __('Le workflow est en cours d\'exécution') }}
                </flux:text>
                {{-- <p class="mt-2">ID: {{ $executionId }}</p> --}}
            </div>
            @if ($data > 0)
                <div class="mt-4 p-4 rounded bg-gray-100" wire:poll.5s="refreshCount">
                    <h3 class="text-lg font-medium mb-2">
                        {{ __('Nombre de liens ajoutés aujourd’hui : ') }} {{ $data }}
                    </h3>
                </div>
            @else
                <div class="mt-4 p-4 rounded" wire:poll.5s="refreshCount">
                    <flux:text class="mt-2">
                        {{ __('Aucun lien enregistré aujourd’hui.') }}
                    </flux:text>
                </div>
            @endif
        @endif
    </div>
</flux:modal>
