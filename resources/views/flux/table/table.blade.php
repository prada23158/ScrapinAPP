<table :paginate="$this->orders">
    <table.columns>
        <table.column>Customer</table.column>
        <table.column sortable :sorted="$sortBy === 'date'" :direction="$sortDirection" wire:click="sort('date')">Date
        </table.column>
        <table.column sortable :sorted="$sortBy === 'status'" :direction="$sortDirection" wire:click="sort('status')">
            Status</table.column>
        <table.column sortable :sorted="$sortBy === 'amount'" :direction="$sortDirection" wire:click="sort('amount')">
            Amount</table.column>
    </table.columns>

    <table.rows>
        @foreach ($this->orders as $order)
            <table.row :key="$order->id">
                <table.cell class="flex items-center gap-3">
                    <avatar size="xs" src="{{ $order->customer_avatar }}" />

                    {{ $order->customer }}
                </table.cell>

                <table.cell class="whitespace-nowrap">{{ $order->date }}</table.cell>

                <table.cell>
                    <badge size="sm" :color="$order->status_color" inset="top bottom">
                        {{ $order->status }}</badge>
                </table.cell>

                <table.cell variant="strong">{{ $order->amount }}</table.cell>

                <table.cell>
                    <button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom">
                    </button>
                </table.cell>
            </table.row>
        @endforeach
    </table.rows>
</table>
