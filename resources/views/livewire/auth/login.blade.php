<x-layouts.auth>
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Connexion')" :description="__('Entrez votre adresse e-mail et votre mot de passe ci-dessous pour vous connecter')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <flux:input name="email" :label="__('Votre adresse e-mail')" type="email" required autofocus
                autocomplete="email" placeholder="email@example.com" />

            <!-- Password -->
            <div class="relative">
                <flux:input name="password" :label="__('Votre mot de passe')" type="password" required
                    autocomplete="current-password" :placeholder="__('Mot de passe')" viewable />

                @if (Route::has('password.request'))
                    <flux:link class="absolute top-0 text-sm end-0" :href="route('password.request')" wire:navigate>
                        {{ __('Mot de passe oublié ?') }}
                    </flux:link>
                @endif
            </div>

            <!-- Remember Me -->
            <flux:checkbox name="remember" :label="__('Se souvenir de moi')" :checked="old('remember')" />

            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full" data-test="login-button">
                    {{ __('Connexion') }}
                </flux:button>
            </div>
        </form>

        @if (Route::has('register'))
            <div class="space-x-1 text-sm text-center rtl:space-x-reverse text-zinc-600 dark:text-zinc-400">
                <span>{{ __('Vous n\'avez pas de compte ?') }}</span>
                <flux:link :href="route('register')" wire:navigate>{{ __('S\'inscrire') }}</flux:link>
            </div>
        @endif
    </div>
</x-layouts.auth>
