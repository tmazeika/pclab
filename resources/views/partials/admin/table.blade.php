<section class="bar">
    @php
        $items = $model::orderBy('id')->get();
        $tableName = $model::tableName();
        $columns = \Illuminate\Support\Facades\Schema::getColumnListing($tableName);
    @endphp

    <h5>{{ $tableName }}</h5>
    <br/>

    @if($items->count())
        <div style="overflow-x: auto">
            <table cellpadding="7">
                <thead>
                <tr>
                    @foreach($columns as $column)
                        <td class="text" style="font-weight: bold">{{ $column }}</td>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr {!! $loop->index % 2 === 0 ? 'style="background-color: #222229"' : '' !!}>
                        @foreach($columns as $column)
                            <td class="text">{{ $item->$column }}</td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</section>
