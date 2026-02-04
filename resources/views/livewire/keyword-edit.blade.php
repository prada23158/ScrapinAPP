<div>
    <flux:modal name="keyword-edit" class="md:w-150">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Modifier un mot-clé</flux:heading>
                <flux:text class="mt-2">Ajouter les informations du mot-clé</flux:text>
            </div>

            @csrf
            <!-- Métiers -->
            <flux:input wire:model="metiers" name="metiers" :label="__('Métiers')" type="text" autofocus
                autocomplete="metiers" :placeholder="__('Métier')" />

            <!-- Villes-->
            <flux:input wire:model="villes" name="villes" :label="__('Villes')" type="text" autofocus
                autocomplete="villes" :placeholder="__('Ville')" />

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full" data-test="register-user-button"
                    wire:click="updateKeyword">
                    {{ __('Modifier un mot-clé') }}
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>
