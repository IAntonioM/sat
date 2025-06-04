@extends('layouts.cabecera')
@section('content')
    <livewire:consolidado.consolidado-component />
@endsection
@push('scripts')
    <script src="{{ asset('js/consolidadoJS.js') }}"></script>
@endpush
