@foreach ($items as $item)
    <tr class="border-b">
        <td class="px-4 py-2">
            {{ data_get($item, $column['field']) }}
        </td>
    </tr>
@endforeach
