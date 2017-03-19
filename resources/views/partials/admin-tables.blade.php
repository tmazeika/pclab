@if($items->count() > 0)
<section>
    @php
        $table = $items->first()->getTable();
        $columns = Schema::getColumnListing($table);
    @endphp

    <h1>{{ $table }}</h1>

    <div style="overflow-x: auto">
        <table cellpadding="5">
            <thead>
                <tr style="font-weight: bold">
                    @foreach($columns as $column)
                        <td>{{ $column }}</td>
                    @endforeach

                    <td></td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        @foreach($columns as $column)
                            <td>{{ $item->getAttribute($column) }}</td>
                        @endforeach

                        <td>
                            <a href="{{ url('admin/update', [$table, $item->id]) }}">
                                <button>Update</button>
                            </a>
                        </td>

                        <td>
                            <a href="{{ url('admin/delete', [$table, $item->id]) }}">
                                <button>Delete</button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <a href="{{ url('admin/create', [$table]) }}">
        <button>Create</button>
    </a>
</section>
@endif
