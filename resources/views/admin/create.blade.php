@extends('layouts.master')

@section('title', 'Admin')

@section('content')
<main class="content">
    <a href="{{ url('admin') }}">Back</a>

    @php($columns = Schema::getColumnListing($table))

    <form method="POST" action="{{ url('admin/create', [$table]) }}">
        {{ csrf_field() }}

        <div style="overflow-x: auto">
            <table cellpadding="5">
                <thead>
                    <tr style="font-weight: bold">
                        @foreach($columns as $column)
                            <td>{{ $column }}</td>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach($columns as $column)
                            <td>
                                <input name="{{ $column }}"/>
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>

        <br/>

        <input type="submit" value="Create"/>
    </form>
</main>
@endsection
