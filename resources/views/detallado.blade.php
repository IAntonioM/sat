@extends('layouts.cabecera')

@section('content')
    <livewire:detallado.detallo-component />
@endsection

@push('scripts')
    <script src="{{ asset('js/detalladoJS.js') }}?v={{ time() }}"></script>
@endpush
