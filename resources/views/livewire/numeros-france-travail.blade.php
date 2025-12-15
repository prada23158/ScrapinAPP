<div class="space-y-6 border border-neutral-200 dark:border-neutral-700 p-4 rounded-lg">
    <div class="overflow-x-auto">
        <table class="w-full table-auto border-collapse bg-white border border-neutral-200 dark:border-neutral-700">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="bg-neutral-100 text-left dark:bg-neutral-800">
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('ID') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Entreprise') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Telephone') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Date de création') }}</th>
                    <th scope="col" class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                        {{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                @foreach ($numeros as $numero)
                    <tr class="even:bg-neutral-50 dark:even:bg-neutral-700/50">
                        <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">{{ $i++ }}</td>
                        <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                            {{ $numero->entreprise }}
                        </td>
                        <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">{{ $numero->telephone }}
                        </td>
                        <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600">
                            {{ \Carbon\Carbon::parse($numero->created_at)->format('d/m/Y') }}
                        </td>
                        <td class="border border-neutral-300 px-4 py-2 dark:border-neutral-600" style="color: seagreen">
                            <flux:button variant="danger" color="red" wire:click="delete({{ $numero->id }})">
                                Supprimer
                            </flux:button>
                            <flux:separator variant="subtle" />

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    @if ($numeros->hasPages())
        <div class="mt-6 flex justify-center">
            {{ $numeros->links('pagination::tailwind') }}
        </div>
    @endif
</div>
