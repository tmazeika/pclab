@extends('layouts.master')

@section('title', 'Build')

@section('content')
<main>
    @each('partials.build.section', $components, 'components')

    <a href="{{ url('checkout') }}">
        <button class="checkout-button">Finished</button>
    </a>
</main>
@endsection

@push('scripts')
<script>
    const ajaxSelectUrl = "{{ url('build/custom/select') }}";
    const csrfToken = "{{ csrf_token() }}";
</script>

<script src="{{ asset('js/app.js') }}"></script>
@endpush
