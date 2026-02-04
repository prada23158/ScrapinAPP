<div class="flex justify-between">
    {{-- <p>composant: {{ get_class($this) }}</p> --}}
    {{-- <p>{{ $message }}</p> --}}
    <div class="p-6 bg-white rounded-lg shadow-lg m-4 order-first">
        <div class="mb-4">
            <flux:heading size="md">Ajouter un mot-clé</flux:heading>
            <flux:text>Ajouter un nouveau mot-clé pour les offres d'emploi.</flux:text>
        </div>
        @csrf
        <flux:field>
            <flux:label>Métier</flux:label>

            <flux:input wire:model="metiers" type="text" />

            <flux:error name="metiers" />
        </flux:field>
        <flux:field>
            <flux:label>Ville</flux:label>

            <flux:input wire:model="villes" type="text" />

            <flux:error name="villes" />

            {{-- <flux:description>Must be at least 8 characters long, include an uppercase letter, a number, and a
                    special character.</flux:description> --}}
        </flux:field>
        <div class="mt-4">
            <flux:button variant="primary" type="submit" wire:click="createKeyword">{{ __('Ajouter') }}</flux:button>
        </div>
    </div>

    {{-- inserer une datatable --}}
    <div class="basis-3xs p-6 bg-white rounded-lg shadow-lg m-4 order-first">
        <div class="mb-4">
            <flux:heading size="md">Mots-clés existants</flux:heading>
            <flux:text>Liste des mots-clés ajoutés pour les offres d'emploi.</flux:text>

        </div>
        <div class="overflow-x-auto">
            <div class="space-y-6 border border-neutral-200 dark:border-neutral-700 p-4 rounded-lg">
                <table
                    class="order-3 w-full table-auto border-collapse bg-white border border-neutral-200 dark:border-neutral-700">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr class="bg-neutral-100 text-left dark:bg-neutral-800">
                            <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ __('ID') }}
                            </th>
                            <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ __('Métier') }}
                            </th>
                            <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ __('Ville') }}
                            </th>
                            <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ __('Date de création') }}
                            </th>
                            <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach ($keywords as $keyword)
                            <tr class="even:bg-neutral-50 dark:even:bg-neutral-700/50">
                                <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                    {{ $i++ }}
                                </td>
                                <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                    {{ $keyword->metiers }}
                                </td>
                                <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                    {{ $keyword->villes }}
                                </td>
                                <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                    {{ \Carbon\Carbon::parse($keyword->date_insertion)->format('d/m/Y') }}
                                </td>
                                <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                    <div class="flex gap-2 justify-start">
                                        @if ($keyword->statut == 1)
                                            <flux:button variant="primary" color="emerald"
                                                wire:click="activateKeyword({{ $keyword->id }})">
                                                Activer
                                            </flux:button>
                                            {{-- @else
                                            <flux:button variant="primary" color="amber"
                                                wire:click="activateKeyword({{ $keyword->id }})">
                                                Désactiver
                                            </flux:button> --}}
                                        @endif
                                        <flux:button variant="danger" wire:click="deleteKeyword({{ $keyword->id }})">
                                            Supprimer
                                        </flux:button>
                                        <flux:button variant="primary" color="blue"
                                            wire:click="editKey({{ $keyword->id }})">
                                            Editer
                                        </flux:button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $keywords->links() }}
        </div>
    </div>
    {{-- composant livewire pour éditer un mot-clé --}}
    <liverwire:keyword-edit />
</div>
