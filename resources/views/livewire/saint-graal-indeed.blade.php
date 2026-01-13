<div class="space-y-6 border border-neutral-200 dark:border-neutral-700 p-4 rounded-lg">
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
                        {{ __('Page_URL') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Telephone') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Adresse1') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Adresse2') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Adresse3') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Email1') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Email2') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Email3') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('website1') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('website2') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('website3') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('contact1') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('contact2') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('contact3') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('contact4') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('contact5') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @if ($graalIndeed->isEmpty())
                    <tr>
                        <td colspan="20" class="px-4 py-2 border-t border-zinc-200 dark:border-zinc-700 text-center">
                            Aucune information disponible.
                        </td>
                    </tr>
                @else
                    <?php $i = 1; ?>
                    @foreach ($graalIndeed as $graal)
                        <tr class="even:bg-neutral-50 dark:even:bg-neutral-700/50">
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">{{ $i++ }}
                            </td>
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ $graal->entreprise }}
                            </td>
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ $graal->lieu }}
                            </td>
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                <u><a href="{{ $graal->Page_URL }}"></a></u>{{ $graal->Page_URL }}
                            </td>
                            {{-- <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ $graal->telephone }} 
                            </td>
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ $graal->adresse1 }}
                            </td>
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ $graal->adresse2 }}
                            </td>
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ $graal->adresse3 }}
                            </td>
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ $graal->email1 }}
                            </td>
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ $graal->email2 }}
                            </td>
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ $graal->email3 }}
                            </td>
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ $graal->website1 }}
                            </td>
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ $graal->website2 }}
                            </td>
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ $graal->website3 }}
                            </td>
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ $graal->contact1 }}
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ $graal->contact2 }}
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ $graal->contact3 }}
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ $graal->contact4 }}
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ $graal->contact5 }}
                            </td>
                            {{-- <p>Composant: {{ get_class($this) }}</p> --}}
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600"
                                style="color: seagreen">
                                <flux:button variant="danger" color="red" wire:click="delete()">
                                    Supprimer
                                </flux:button>
                                <flux:separator variant="subtle" />
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    @if ($graalIndeed->hasPages())
        <div class="mt-6 flex justify-center">
            {{ $graalIndeed->links('pagination::tailwind') }}
        </div>
    @endif
</div>
