@extends('layouts.master')

@section('title', 'Lab')
@php($active = 'lab')

@section('main')
    <main>
        @each('partials.lab.section', $components, 'components')

        {{--<a href="{{ url('lab/checkout') }}">--}}
            {{--<button>Finished</button>--}}
        {{--</a>--}}
    </main>
@endsection

@push('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endpush
