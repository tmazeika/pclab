<section class="admin-section">
    @php
        $items = $model::orderBy('id')->get();
        $tableName = (new $model)->getTable();
        $columns = \Illuminate\Support\Facades\Schema::getColumnListing($tableName);
    @endphp

    <h2>{{ $tableName }}</h2>

    @if($items->count())
        <div style="overflow-x: auto">
            <table cellpadding="7">
                <thead>
                <tr>
                    @foreach($columns as $column)
                        <td style="font-weight: 700">{{ $column }}</td>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr {!! $loop->index % 2 === 0 ? 'style="background-color: #363636"' : '' !!}>
                        @foreach($columns as $column)
                            <td>{{ $item->$column }}</td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</section>
