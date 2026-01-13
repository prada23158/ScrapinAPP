<!-- resources/views/livewire/info-ft.blade.php -->
<div class="space-y-6 border border-neutral-200 dark:border-neutral-700 p-4 rounded-lg">
    <flux:input icon="magnifying-glass" wire:model.live="searchInfos" placeholder="Rechercher par entreprise..." />
    <!-- Message si recherche active -->
    @if ($searchInfos)
        <div class="mb-4 text-sm text-gray-600">
            Résultats pour : <strong>{{ $searchInfos }}</strong>
            <button wire:click="$set('searchInfos', '')" class="ml-2 text-blue-600 hover:underline">
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
                        {{ __('Adresse1') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Adresse2') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Adresse3') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Phone1') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Phone2') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Phone3') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Email1') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Email2') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Email3') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Website1') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Website2') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Website3') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Date de création') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Statut') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @if ($infos->isEmpty())
                    <tr>
                        <td colspan="6" class="px-4 py-2 border-t border-zinc-200 dark:border-zinc-700 text-center">
                            Aucune information disponible.
                        </td>
                    </tr>
                @else
                    <?php $i = 1; ?>
                    @foreach ($infos as $info)
                        <tr class="even:bg-neutral-50 dark:even:bg-neutral-700/50">
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">{{ $i++ }}
                            </td>
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ $info->entreprise }}
                            </td>
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ $info->adresse1 }}
                            </td>
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ $info->adresse2 }}
                            </td>
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ $info->adresse3 }}
                            </td>
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ $info->phone1 }}
                            </td>
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ $info->phone2 }}
                            </td>
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ $info->phone3 }}
                            </td>
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ $info->email1 }}
                            </td>
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ $info->email2 }}
                            </td>
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ $info->email3 }}
                            </td>
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ $info->website1 }}
                            </td>
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ $info->website2 }}
                            </td>
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ $info->website3 }}
                            </td>
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                                {{ \Carbon\Carbon::parse($info->date_insertion)->format('d/m/Y H:i:s') }}
                            </td>
                            @if ($info->statut == '1')
                                <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600"
                                    style="color: red;">
                                    Inactif
                                </td>
                            @else
                                <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600"
                                    style="color: green;">
                                    Actif
                                </td>
                            @endif
                            <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600"
                                style="color: seagreen">
                                <flux:button variant="danger" color="red" wire:click="delete({{ $info->id }})">
                                    Supprimer
                                </flux:button>
                                <flux:separator variant="subtle" />
                                @if ($info->statut == '0')
                                    <flux:button variant="danger" color="red">
                                        Activer
                                    </flux:button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    @if ($infos->hasPages())
        <div class="mt-6 flex justify-center">
            {{ $infos->links() }}
        </div>
    @endif
</div>
