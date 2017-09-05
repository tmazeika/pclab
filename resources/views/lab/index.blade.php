@extends('layouts.master')

@section('title', 'Lab')
@php($active = 'lab')

@section('main')
    <main class="lab">
        @each('partials.lab.section', $components, 'components')

        <a href="{{ url('/lab/checkout') }}">
            <button>Checkout</button>
        </a>
    </main>
@endsection

@push('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endpush
