@extends('layouts.cabecera')

@section('content')
    <div class="card " style="background-image: url(assets/media/logos/fondo1.jpg);background-position: center center;">
        <div class="card-body pt-9 pb-0">
            <!--begin::Details-->
            <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
                <!--begin::Wrapper-->
                <div class="flex-grow-1">
                    <!--begin::Head-->
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <!--begin::Details-->
                        <div class="d-flex flex-column">
                            <!--begin::Status-->
                            <div class="d-flex align-items-center mb-1">
                                <span class="text-gray-800 text-primary fs-1 fw-bold me-3">Deudas Detalladas</span>
                            </div>
                            <!--end::Status-->
                            <!--begin::Description-->
                            <div class="d-flex flex-wrap fw-semibold mb-4 fs-5 text-gray-400">Deudas del Contribuyente al
                                {{ $fechaActual }}</div>
                            <!--end::Description-->
                        </div>
                        <!--end::Details-->
                        <!--begin::Actions-->
                        <div class="d-flex mb-4">
                            <div
                                class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3 badge-light-primary">
                                <div class="fw-semibold fs-6 text-gray-400">Su Deuda Actual es:</div>
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    <div class=" fw-bold" data-kt-countup="true" data-kt-countup-value="{{ $totalDeuda }}"
                                        data-kt-countup-prefix="S/." style="font-size:30px">0</div>
                                </div>
                                <!--end::Number-->
                            </div>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Head-->
                </div>
            </div>
        </div>
    </div>
    <livewire:detallado.detallo-component />
@endsection

@push('scripts')
    <script src="{{ asset('js/detalladoJS.js') }}?v={{ time() }}"></script>
@endpush
