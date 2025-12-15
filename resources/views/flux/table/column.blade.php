@props(['name', 'sortBy', 'sortDirection'])

<flux:table.column sortable :sorted="$sortBy === '{{ $name }}'" :direction="$sortDirection"
    wire:click="sort('{{ $name }}')" {{ $attributes }}>
    {{ $slot }}
</flux:table.column>
