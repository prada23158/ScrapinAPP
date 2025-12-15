<div>
    <flux:modal name="edit-user" class="md:w-150">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Modifier un Compte</flux:heading>
                <flux:text class="mt-2">Modifier les informations du compte de l'utilisateur</flux:text>
            </div>

            @csrf
            <!-- Name -->
            <flux:input wire:model="name" name="name" :label="__('Nom')" type="text" required autofocus autocomplete="name"
                :placeholder="__('Nom complet')" />

            <!-- Email Address -->
            <flux:input wire:model="email" name="email" :label="__('Adresse e-mail')" type="email" required autocomplete="email"
                placeholder="email@example.com" />

            <!-- Password -->
            <flux:input wire:model="password" name="password" :label="__('Mot de passe')" type="password" required autocomplete="new-password"
                :placeholder="__('Mot de passe')" viewable />

            <!-- Confirm Password -->
            <flux:input wire:model="password_confirmation" name="password_confirmation" :label="__('Confirmer le mot de passe')" type="password" required
                autocomplete="new-password" :placeholder="__('Confirmer le mot de passe')" viewable />

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full" data-test="register-user-button" wire:click="updateUser">
                    {{ __('Modifier le compte') }}
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>
