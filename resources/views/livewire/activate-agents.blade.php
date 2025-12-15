<div class="flex p-5 w-full">
    <flux:modal name="modalone-francetravail" class="w-full max-w-5xl modal-dialog modal-lg">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Liste des liens France Travail Scrappés</flux:heading>
                <flux:subheading class="mt-2">Voici tous les liens récupérés</flux:subheading>
            </div>

            <div
                class="table-responsive flex max-h-[60vh] overflow-x-auto overflow-y-auto border border-zinc-200 dark:border-zinc-700 rounded-lg">
                <table class="min-w-[900px] w-full table-auto border-collapse">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr class="bg-neutral-100 text-left dark:bg-neutral-800">
                            <th class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">{{ __('ID') }}
                            </th>
                            <th class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">{{ __('Titre') }}
                            </th>
                            <th class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">{{ __('Lien') }}
                            </th>
                            <th class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ __('Date de création') }}</th>
                            <th class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">{{ __('Statut') }}
                            </th>
                            <th class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">{{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?= $i = 1 ?>
                        @foreach ($resultats as $resultat)
                            <tr class="bg-white dark:bg-zinc-900">
                                <td class="px-4 py-2 border-t border-zinc-200 dark:border-zinc-700">{{ $i++ }}
                                </td>
                                <td class="px-4 py-2 border-t border-zinc-200 dark:border-zinc-700">
                                    {{ $resultat->titre_offre }}
                                </td>
                                <td
                                    class="px-4 py-2 border-t border-zinc-200 dark:border-zinc-700 break-all text-xs md:text-sm">
                                    https://candidat.francetravail.fr/offres/emploi/garges-les-gonesse/v163
                                </td>
                                <td class="px-4 py-2 border-t border-zinc-200 dark:border-zinc-700">10/12/2025</td>
                                <td class="px-4 py-2 border-t border-zinc-200 dark:border-zinc-700">Actif</td>
                                <td class="px-4 py-2 border-t border-zinc-200 dark:border-zinc-700">
                                    <span class="text-green-600 font-medium">Actif</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex gap-2 justify-end pt-4 border-t">
                <flux:modal.close>
                    <flux:button variant="ghost">Fermer</flux:button>
                </flux:modal.close>
            </div>
        </div>
    </flux:modal>
</div>
