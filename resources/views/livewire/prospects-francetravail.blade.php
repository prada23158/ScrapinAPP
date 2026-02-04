<flux:modal name="prospects-francetravail" class="min-w-[96rem]">
    {{-- <p>composant: {{ get_class($this) }}</p> --}}
    <div class="space-y-6">
        @if (!$this->success && in_array($this->status, ['error', 'failed']))
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
                    <strong>{{ __('Message :') }} {{ $errorMessage }}</strong>
                </flux:text>

                @if ($this->errorHint)
                    <flux:text class="mt-2 text-sm">
                        <strong>{{ __('Hint :') }} {{ $this->errorHint }}</strong>
                    </flux:text>
                @endif
            </div>
        @elseif (!$this->success && in_array($this->status, ['canceled']))
            <div class="mt-8 p-4 rounded">
                <flux:badge variant='solid' color='red'>
                    {{ __('Code d\'erreur') }} : {{ $errorCode }}
                </flux:badge>
                @if (in_array($this->status, ['canceled']))
                    <flux:text class="mt-2 text-yellow-600 font-semibold">
                        {{ __('La dernière exécution a été annulée') }}
                    </flux:text>
                @endif

                <div class="flex justify-center items-center">
                    <img src="warning.png" alt="" class="w-16 h-16 mt-4">
                </div>

                <flux:text class="mt-2">
                    <strong>{{ __('Message :') }} {{ $errorMessage }}</strong>
                </flux:text>

                @if ($this->errorHint)
                    <flux:text class="mt-2 text-sm">
                        <strong>{{ __('Hint :') }} {{ $this->errorHint }}</strong>
                    </flux:text>
                @endif
            </div>
        @elseif ($this->success && $this->status === 'success' && $this->finished)
            <div class="mt-8 p-4 rounded">
                <flux:badge variant='solid' color='green'>
                    {{ __('Terminé avec succès') }}
                </flux:badge>
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

                            {{ __('total prospects scrappés : ') }} {{ $data }}
                        </h3>
                    </div>
                @else
                    <div class="mt-4 p-4 rounded" wire:poll.5s="refreshCount">
                        <flux:text class="mt-2">
                            {{ __('Aucun prospect enregistré.') }}
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
                    <h3 class="text-lg font-medium mb-2">
                        {{ __('Nombre de prospects trouvés: ') }} {{ $data }}
                    </h3>

                    {{-- prospects restants --}}
                    @if ($offresNotScrapped > 0)
                        <h3 class="text-lg font-medium mb-2">
                            {{ __('entreprises restantes: ') }} {{ $offresNotScrapped }}
                        </h3>
                    @endif
                </div>
            @else
                <div class="mt-4 p-4 rounded" wire:poll.5s="refreshCount">
                    <flux:text class="mt-2">
                        {{ __('Aucun prospect enregistré.') }}
                    </flux:text>
                </div>
            @endif
        @endif
    </div>
</flux:modal>
