<div>
    <flux:modal.trigger name="create-user" class="mb-4">
        <flux:button>Ajouter</flux:button>
    </flux:modal.trigger>

    {{-- <livewire:card-one /> --}}
    {{-- composant de création d'utilisateur views/livewire/user-create --}}
    <livewire:user-create />
    {{-- composant de modification d'utilisateur views/livewire/user-edit --}}
    <livewire:user-edit />
    {{-- suppression d'un utilisateur --}}
    <flux:modal name="delete-user" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Voulez-vous vraiment supprimer cet utilisateur ?</flux:heading>

                <flux:text class="mt-2">
                    Vous êtes sur le point de supprimer cet utilisateur.<br>
                    Cette action ne peut pas être annulée.
                </flux:text>
            </div>

            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="danger" wire:click="destroy({{ $userId }})">Supprimer
                </flux:button>
            </div>
        </div>
    </flux:modal>

    <div class="overflow-x-auto">
        <table class="w-full table-auto border-collapse border border-neutral-200 dark:border-neutral-700">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="bg-neutral-100 text-left dark:bg-neutral-800">
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Name') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Email') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Date de création') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="even:bg-neutral-50 dark:even:bg-neutral-700/50">
                        <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">{{ $user->name }}</td>
                        <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">{{ $user->email }}</td>
                        <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                            {{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i') }}
                        </td>
                        <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                            <flux:button size="sm" wire:click="edit({{ $user->id }})">Modifier
                            </flux:button>

                            <flux:button variant="danger" color="red" wire:click="delete({{ $user->id }})">
                                Supprimer
                            </flux:button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
