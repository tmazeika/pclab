<section class="bar">
    @php
        $items = $model::all();
        $tableName = $model::tableName();
        $columns = \Illuminate\Support\Facades\Schema::getColumnListing($tableName);
    @endphp

    <header class="bar">
        <h5>{{ $tableName }}</h5>
    </header>

    @if($items->count())
        <div style="overflow-x: auto">
            <table cellpadding="7">
                <thead>
                    <tr style="font-weight: bold">
                        @foreach($columns as $column)
                            <td class="text">{{ $column }}</td>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr>
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
