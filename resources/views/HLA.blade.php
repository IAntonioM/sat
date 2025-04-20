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
                            <span class="text-gray-800 text-primary fs-1 fw-bold me-3">Hoja de Liquidación (HLA)</span>
                        </div>
                        <!--end::Status-->
                        <!--begin::Description-->
                        <div class="d-flex flex-wrap fw-semibold mb-4 fs-5 text-gray-400">Deudas del Contribuyente al {{ now()->format('d/m/Y') }}</div>
                        <!--end::Description-->
                    </div>
                    <!--end::Details-->
                    <!--begin::Actions-->
                    <div class="d-flex mb-4">
                        <!-- Year selector -->
                        <select class="form-select form-select-sm me-3" id="kt_hla_year_select">
                            @php $currentYear = date('Y'); @endphp
                            @for($i = $currentYear; $i >= $currentYear - 10; $i--)
                                <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                        <a href="#" class="btn btn-primary" id="kt_hla_print_btn"><i class="fa-solid fa-print"></i>Imprimir</a>
                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Head-->
            </div>
        </div>
    </div>
</div>

<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start " style="padding-right: calc(0px * .5); padding-left: calc(0px * .5);">
    <!--begin::Post-->
    <div class="content flex-row-fluid" id="kt_content">
        <!--begin::Products-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header align-items-center py-5 gap-2 gap-md-5" style="flex-wrap: initial">
                <div class="col-xl-3"><img src="assets/media/logos/custom-3-h25-2.png" alt=""></div>
                <div class="col-xl-6" style="text-align: center"><span class="fs-1">DETERMINACIÓN DE ARBITRIOS {{ $year }}</span><br>
                </div>
                <div class="col-xl-3" style="text-align: center"><span class="fs-1">HLA</span><br><span>(Hoja de Liquidación)</span></div>

            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0" >
                <div class="col-xl-12" style="border: 0px solid var(--bs-gray-300); padding:10px;">
                    I. DATOS DEL CONTRIBUYENTE
                </div>
                <div class="col-xl-12 row" style="border: 1px solid var(--bs-gray-300);margin-left: 0;margin-right:0;--bs-gutter-x: 0rem;">

                    <div class="col-xl-10 row" style="margin-left: 0;margin-right:0;--bs-gutter-x: 0rem;">
                        <div class="col-xl-4" style="font-size:10px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center ">
                            CONTRIBUYENTE:
                        </div>
                        <div class="col-xl-8" style="font-size:10px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;">
                            {{ $contributor->nombre ?? '' }}
                        </div>

                        <div class="col-xl-4" style="font-size:10px;border-right: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center ">
                            DOMICILIO FISCAL:
                        </div>
                        <div class="col-xl-8" style="font-size:10px;border-right: 1px solid var(--bs-gray-300); padding:10px;">
                            {{ $contributor->direcc ?? '' }}
                        </div>
                    </div>
                    <div class="col-xl-2 row" style="margin-left: 0;margin-right:0;--bs-gutter-x: 0rem;">
                        <div class="col-xl-12 row" >
                            <div class="col-xl-12 " style="font-size:10px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:12px;background-color:#f8f8f9;text-align: center ">
                                CODIGO DE CONTRIBUYENTE
                            </div>
                            <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                                {{ $contributor->codigo ?? '' }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12" style="border: 0px solid var(--bs-gray-300); padding:10px;">
                    II. DETERMINACION (S/.)
                </div>

                <div class="col-xl-12 row hla-details-container" style="border: 1px solid var(--bs-gray-300);margin-left: 0;margin-right:0;--bs-gutter-x: 0rem;">
                    <div class="col-xl-1 row header-row" >
                        <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center ">
                            CODIGO PREDIO
                        </div>
                    </div>
                    <div class="col-xl-2 row header-row" >
                        <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center ">
                            UBICACION DEL PREDIO
                        </div>
                    </div>
                    <div class="col-xl-1 row header-row" >
                        <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center ">
                            FRONTIS
                        </div>
                    </div>
                    <div class="col-xl-1 row header-row" >
                        <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center ">
                            ZONA
                        </div>
                    </div>
                    <div class="col-xl-1 row header-row" >
                        <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center ">
                            USO
                        </div>
                    </div>
                    <div class="col-xl-1 row header-row" >
                        <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px 0px 10px 0px;background-color:#f8f8f9;text-align: center ">
                            % PROP
                        </div>
                    </div>
                    <div class="col-xl-1 row header-row" >
                        <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px 0px 10px 0px;background-color:#f8f8f9;text-align: center ">
                            RESIDUOS SOLIDOS
                        </div>
                    </div>
                    <div class="col-xl-1 row header-row" >
                        <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px 0px 10px 0px;background-color:#f8f8f9;text-align: center ">
                            BARRIDO DE CALLES
                        </div>
                    </div>
                    <div class="col-xl-1 row header-row" >
                        <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px 0px 10px 0px;background-color:#f8f8f9;text-align: center ">
                            PARQUES Y JARDINES
                        </div>
                    </div>
                    <div class="col-xl-1 row header-row" >
                        <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px 0px 10px 0px;background-color:#f8f8f9;text-align: center ">
                            SERENAZGO
                        </div>
                    </div>
                    <div class="col-xl-1 row header-row" >
                        <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center ">
                            TOTAL
                        </div>
                    </div>

                    @foreach($hlaDetails as $detail)
                    <div class="col-xl-1 row" >
                        <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            {{ $detail->id_anexo ?? '' }}
                        </div>
                    </div>
                    <div class="col-xl-2 row" >
                        <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            {{ $detail->direccion1 ?? '' }}
                        </div>
                    </div>
                    <div class="col-xl-1 row" >
                        <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            {{ $detail->frontis ?? '' }}
                        </div>
                    </div>
                    <div class="col-xl-1 row" >
                        <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            {{ $detail->zona ?? '' }}
                        </div>
                    </div>
                    <div class="col-xl-1 row" >
                        <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            {{ $detail->uso ?? '' }}
                        </div>
                    </div>
                    <div class="col-xl-1 row" >
                        <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            {{ $detail->porcen ?? '' }}
                        </div>
                    </div>
                    <div class="col-xl-1 row" >
                        <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            {{ $detail->resiso ?? '0.00' }}
                        </div>
                    </div>
                    <div class="col-xl-1 row" >
                        <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            {{ $detail->limpub ?? '0.00' }}
                        </div>
                    </div>
                    <div class="col-xl-1 row" >
                        <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            {{ $detail->parjar ?? '0.00' }}
                        </div>
                    </div>
                    <div class="col-xl-1 row" >
                        <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            {{ $detail->serena ?? '0.00' }}
                        </div>
                    </div>
                    <div class="col-xl-1 row" >
                        <div class="col-xl-12" style="border-right: 0px solid var(--bs-gray-300); padding:10px;text-align: center">
                            {{ $detail->total ?? '0.00' }}
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="col-xl-12 row" style="border: 1px solid var(--bs-gray-300);margin-left: 0;margin-right:0;--bs-gutter-x: 0rem;">
                    <div class="col-xl-7 row" >
                        <div class="col-xl-12 " style="font-size:10px;border-right: 1px solid var(--bs-gray-300);border-bottom: 0px solid var(--bs-gray-300);border-top: 0px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: right ">
                            SUB TOTAL:
                        </div>
                    </div>
                    <div class="col-xl-1 row" >
                        <div class="col-xl-12 sum-resiso" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            {{ $hlaSummary->sum_resiso ?? '0.00' }}
                        </div>
                    </div>
                    <div class="col-xl-1 row" >
                        <div class="col-xl-12 sum-limpub" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            {{ $hlaSummary->sum_limpub ?? '0.00' }}
                        </div>
                    </div>
                    <div class="col-xl-1 row" >
                        <div class="col-xl-12 sum-parjar" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            {{ $hlaSummary->sum_parjar ?? '0.00' }}
                        </div>
                    </div>
                    <div class="col-xl-1 row" >
                        <div class="col-xl-12 sum-serena" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            {{ $hlaSummary->sum_serena ?? '0.00' }}
                        </div>
                    </div>
                    <div class="col-xl-1 row" >
                        <div class="col-xl-12 sum-total" style="border-right: 0px solid var(--bs-gray-300); padding:10px;text-align: center">
                            {{ $hlaSummary->total ?? '0.00' }}
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Products-->
    </div>
    <!--end::Post-->
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/HLAJS.js') }}"></script>
@endpush
