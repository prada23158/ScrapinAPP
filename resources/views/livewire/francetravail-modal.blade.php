{{-- <div class="p-6 bg-white dark:bg-zinc-800 rounded-lg shadow-md"> --}}
<flux:modal name="modal-francetravail" class="max-w-7xl w-full">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Liste des liens France Travail Scrappés</flux:heading>
            <flux:subheading class="mt-2">Voici tous les liens récupérés</flux:subheading>
        </div>

        <div
            class="table-responsive flex max-w-[98vw] overflow-x-auto overflow-y-auto border border-zinc-200 dark:border-zinc-700 rounded-lg">
            <table class="max-w-[98vw] w-full table-auto border-collapse">
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
                        {{-- <th class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">{{ __('Actions') }}
                            </th> --}}
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($resultats as $resultat)
                        <tr class="bg-white dark:bg-zinc-900">
                            <td class="px-4 py-2 border-t border-zinc-200 dark:border-zinc-700">{{ $i++ }}
                            </td>
                            <td class="px-4 py-2 border-t border-zinc-200 dark:border-zinc-700">
                                {{ $resultat->titre_offre }}
                            </td>
                            <td
                                class="px-4 py-2 border-t border-zinc-200 dark:border-zinc-700 break-all text-xs md:text-sm">
                                {{ $resultat->lien_offre }}
                            </td>
                            <td class="px-4 py-2 border-t border-zinc-200 dark:border-zinc-700">
                                {{ \Carbon\Carbon::parse($resultat->created_at)->format('d/m/Y H:i:s') }}</td>
                            @if ($resultat->status == '1')
                                <td class="px-4 py-2 border-t border-zinc-200 dark:border-zinc-700" style="color: red;">
                                    Inactif
                                </td>
                            @else
                                <td class="px-4 py-2 border-t border-zinc-200 dark:border-zinc-700"
                                    style="color: green;">
                                    Actif
                                </td>
                            @endif
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
    <!-- Pagination Links -->
    @if ($resultats->hasPages())
        {{ $resultats->links() }}
    @endif
</flux:modal>
<!-- Pagination -->
{{-- <flux:pagination :paginator="$orders" /> --}}
{{-- </div> --}}
