<div class="space-y-6 border border-neutral-200 dark:border-neutral-700 p-4 rounded-lg">
    <flux:input icon="magnifying-glass" wire:model.live="searchOffres"
        placeholder="Rechercher par entreprise, poste ou lieu..." />
    <!-- Message si recherche active -->
    @if ($searchOffres)
        <div class="mb-4 text-sm text-gray-600">
            Résultats pour : <strong>{{ $searchOffres }}</strong>
            <button wire:click="$set('searchOffres', '')" class="ml-2 text-blue-600 hover:underline">
                Effacer
            </button>
        </div>
    @endif
    <div class="overflow-x-auto">
        <table class="w-full table-auto border-collapse bg-white border border-neutral-200 dark:border-neutral-700">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="bg-neutral-100 text-left dark:bg-neutral-800">
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('ID') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Poste') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Entreprise') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Lieu') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Contrat') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Lien') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Date de création') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Statut') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                @foreach ($offres as $offre)
                    <tr class="even:bg-neutral-50 dark:even:bg-neutral-700/50">
                        <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">{{ $i++ }}
                        </td>
                        <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">{{ $offre->poste }}
                        </td>
                        <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                            {{ $offre->entreprise }}</td>
                        <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">{{ $offre->lieu }}
                        </td>
                        <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">{{ $offre->contrat }}
                        </td>
                        <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600"><u><a
                                    href="{{ $offre->page_url }}">{{ $offre->page_url }}</a></u>
                        </td>
                        <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                            {{ \Carbon\Carbon::parse($offre->date_insertion)->format('d/m/Y H:i:s') }}</td>
                        @if ($offre->statut == '1')
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600" style="color: red;">
                                Inactif
                            </td>
                        @else
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600"
                                style="color: green;">
                                Actif
                            </td>
                        @endif
                        <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600" style="color: seagreen">
                            <flux:button variant="danger" color="red" wire:click="delete({{ $offre->id }})">
                                Supprimer
                            </flux:button>
                            <flux:separator variant="subtle" />
                            @if ($offre->status == '0')
                                <flux:button variant="danger" color="red">
                                    Activer
                                </flux:button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    @if ($offres->hasPages())
        <div class="mt-6 flex justify-center">
            {{ $offres->links() }}
        </div>
    @endif
</div>
