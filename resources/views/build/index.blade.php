@extends('layouts.master')

@section('title', 'Build')
@php($active = 'build')

@section('content')
    <main>
        @each('partials.build.section', $components, 'components')

        <a href="{{ url('build/checkout') }}">
            <button>Finished</button>
        </a>
    </main>
@endsection

@push('scripts')
<script src="{{ asset('js/app.js') }}"></script>
@endpush
