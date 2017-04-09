<section>
    @php
        $items = $model::all();
        $tableName = $model::tableName();
        $columns = Schema::getColumnListing($tableName);
    @endphp

    <h1>{{ $tableName }}</h1>

    @if($items->count() > 0)
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
                                <td>{{ $item->$column }}</td>
                            @endforeach

                            <td>
                                <a href="{{ url('admin/update', [$tableName, $item->id]) }}">
                                    <button>Update</button>
                                </a>
                            </td>

                            <td>
                                <a href="{{ url('admin/delete', [$tableName, $item->id]) }}">
                                    <button>Delete</button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <a href="{{ url('admin/create', [$tableName]) }}">
        <button>Create</button>
    </a>
</section>
