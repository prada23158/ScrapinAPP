<div class="space-y-6 border border-neutral-200 dark:border-neutral-700 p-4 rounded-lg">
    <flux:input icon="magnifying-glass" wire:model.live="searchContacts"
        placeholder="Rechercher par entreprise, poste ou lieu..." />
    <!-- Message si recherche active -->
    @if ($searchContacts)
        <div class="mb-4 text-sm text-gray-600">
            Résultats pour : <strong>{{ $searchContacts }}</strong>
            <button wire:click="$set('searchContacts', '')" class="ml-2 text-blue-600 hover:underline">
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
                        {{ __('Entreprise') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Contact1') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Contact2') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Contact3') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Contact4') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Contact5') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Date de création') }}</th>
                    {{-- <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Actions') }}</th> --}}
                </tr>
            </thead>
            <tbody>
                @if ($contacts->isEmpty())
                    <tr>
                        <td colspan="7" class="px-4 py-2 border-t border-zinc-200 dark:border-zinc-700 text-center">
                            Aucune information disponible.
                        </td>
                    </tr>
                @else
                    <?php $i = 1; ?>
                    @foreach ($contacts as $contact)
                        <tr class="even:bg-neutral-50 dark:even:bg-neutral-700/50">
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">{{ $i++ }}
                            </td>
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                <u>{{ $contact->entreprise }}</u>
                            </td>
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ $contact->contact1 }}
                            </td>
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ $contact->contact2 }}</td>
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ $contact->contact3 }}</td>
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ $contact->contact4 }}</td>
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ $contact->contact5 }}</td>
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ \Carbon\Carbon::parse($contact->date_insertion)->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    @if ($contacts->hasPages())
        <div class="mt-6 flex justify-center">
            {{ $contacts->links() }}
        </div>
    @endif
</div>
