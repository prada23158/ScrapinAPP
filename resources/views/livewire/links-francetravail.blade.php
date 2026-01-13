<div class="space-y-6 border border-neutral-200 dark:border-neutral-700 p-4 rounded-lg">
    <div class="overflow-x-auto">
        <table class="w-full table-auto border-collapse bg-white border border-neutral-200 dark:border-neutral-700">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="bg-neutral-100 text-left dark:bg-neutral-800">
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('ID') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Titre') }}</th>
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
                @foreach ($links as $link)
                    <tr class="even:bg-neutral-50 dark:even:bg-neutral-700/50">
                        <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">{{ $i++ }}</td>
                        <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">{{ $link->titre_offre }}
                        </td>
                        <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600"><u><a
                                    href="{{ $link->lien_offre }}">{{ $link->lien_offre }}</a></u>
                        </td>
                        <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                            {{ \Carbon\Carbon::parse($link->created_aat)->format('d/m/Y') }}
                        </td>
                        @if ($link->status == '1')
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
                            <flux:button variant="danger" color="red" wire:click="delete({{ $link->id }})">
                                Supprimer
                            </flux:button>
                            <flux:separator variant="subtle" />
                            @if ($link->status == '0')
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
    @if ($links->hasPages())
        <div class="mt-6 flex justify-center">
            {{ $links->links() }}
        </div>
    @endif
</div>
