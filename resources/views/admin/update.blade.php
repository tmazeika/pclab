@extends('layouts.master')

@section('title', 'Admin')

@section('content')
<main class="content">
    <a href="{{ url('admin') }}">Back</a>

    <form method="POST" action="{{ url('admin/update', [$item->getTable(), $item->id]) }}">
        {{ csrf_field() }}

        <div style="overflow-x: auto">
            <table cellpadding="5">
                <thead>
                    <tr style="font-weight: bold">
                        @foreach($columns = Schema::getColumnListing($item->getTable()) as $column)
                            <td>{{ $column }}</td>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach($columns as $column)
                            <td>
                                <input name="{{ $column }}" value="{{ $item->$column or '' }}"/>
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>

        <br/>

        <input type="submit" value="Update"/>
    </form>
</main>
@endsection
