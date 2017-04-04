@extends('layouts.master')

@section('title', 'Custom Build')

@section('content')
<main class="content">
    @each('partials.build.component', [
        'PCForge\Models\ChassisComponent',
        'PCForge\Models\ProcessorComponent',
        'PCForge\Models\CoolingComponent',
        'PCForge\Models\GraphicsComponent',
        'PCForge\Models\MemoryComponent',
        'PCForge\Models\MotherboardComponent',
        'PCForge\Models\StorageComponent',
        'PCForge\Models\PowerComponent',
    ], 'model')
</main>
@endsection

@push('scripts')
<script>
    const ajaxSelectUrl = "{{ url('build/custom/select') }}";
    const csrfToken = "{{ csrf_token() }}";
</script>

<script src="{{ asset('js/app.js') }}"></script>
@endpush
