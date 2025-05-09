@extends('layouts.cabecera')
@section('content')

<div class="card " style="background-image: url(assets/media/logos/fondo1.jpg);background-position: center center;">
    <div class="card-body pt-9 pb-0">
        <!--begin::Details-->
        <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
            <!--begin::Image-->
            <!--<div class="d-flex flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
                <img class="mw-50px mw-lg-75px" src="assets/media/svg/brand-logos/volicity-9.svg" alt="image" />
            </div>-->
            <!--end::Image-->
            <!--begin::Wrapper-->
            <div class="flex-grow-1">
                <!--begin::Head-->
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <!--begin::Details-->
                    <div class="d-flex flex-column">
                        <!--begin::Status-->
                        <div class="d-flex align-items-center mb-1">
                            <span class="text-gray-800 text-primary fs-1 fw-bold me-3">Record de Papeletas </span>
                            <!--<span class="badge badge-light-success me-auto">In Progress</span>-->
                        </div>
                        <!--end::Status-->
                        <!--begin::Description-->
                        <div class="d-flex flex-wrap fw-semibold mb-4 fs-5 text-gray-400">Papeletas del Infractor al    {{ $fechaActual }}</div>
                        <!--end::Description-->
                    </div>
                    <!--end::Details-->
                    <!--begin::Actions-->
                    <div class="d-flex mb-4">
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3 badge-light-primary">
                            <div class="fw-semibold fs-6 text-gray-400">Su Deuda Actual es:</div>
                            <!--begin::Number-->
                            <div class="d-flex align-items-center">
                                <!--<i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>-->
                                <div class=" fw-bold" data-kt-countup="true" data-kt-countup-value="{{$totales}}" data-kt-countup-prefix="S/." style="font-size:30px">0</div>
                            </div>
                            <!--end::Number-->
                            <!--begin::Label-->

                            <!--end::Label-->
                        </div>
                        <!--begin::Menu-->

                        <!--end::Menu-->
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
            <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->

                    <form id="search_form" action="{{ route('record_papeleta') }}" method="GET" class="d-flex align-items-center gap-2">
                        @csrf
                        <div class="w-300 mw-350px">
                            <input type="text" name="termBusq" id="search_input" placeholder="Buscar por DNI o Placa..."
                                   autocomplete="off" class="form-control bg-transparent"
                                   value="{{ request()->input('termBusq') }}">
                        </div>
                        <div>
                            <button id="btnFiltrar" class="btn btn-success" type="submit">
                                <i class="fa-solid fa-filter"></i>
                                Filtrar
                            </button>
                        </div>
                    </form>
                    <!--end::Search-->
                </div>
                <!--end::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">


                    <!--begin::Add product-->
                    <a href="{{ route('reporte', ['tipo' => 'reporteRecordPapeletas','termBusq'=>$termBusq]) }}" target="_blank" class="btn btn-primary"><i class="fa-solid fa-print"></i>Imprimir Record de Infracciones</a>

                    <!--end::Add product-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5 table-bordered" id="kt_ecommerce_sales_table">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0" style="background-color:#f8f8f9;">

                            <th class="min-w-30px" style="text-align: center;">DNI/RUC</th>
                            <th class="min-w-175px" style="text-align: center;">Nro. Papeleta</th>
                            <th class="min-w-30px" style="text-align: center;">Placa</th>
                            <th class=" min-w-30px" style="text-align: center;">Infracción</th>
                            <th class=" min-w-30px" style="text-align: center;">Fecha de Infracción</th>
                            <th class=" min-w-30px" style="text-align: center;">Infractor</th>
                            <th class=" min-w-30px" style="text-align: center;">Estado</th>

                            <th class=" min-w-30px" style="text-align: center;">Deuda</th>
                            <th class=" min-w-30px" style="text-align: center;">Deuda-Dscto</th>


                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @forelse($resumenData as $item)
                            <tr style="text-align: center; font-size:12px">
                                <td>{{ $item->nrodoc }}</td>
                                <td>{{ $item->nro_papeleta }}</td>
                                <td>{{ $item->placa }}</td>
                                <td>{{ $item->infraccion }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->fecha_infraccion)->format('d/m/Y') }}</td>
                                <td>{{ $item->infractor }}</td>
                                <td>
                                    @if($item->estado == 1)
                                        <div class="badge badge-light-danger" style="font-size:12px">Pendiente</div>
                                    @else
                                        <div class="badge badge-light-success" style="font-size:12px">Cancelado</div>
                                    @endif
                                </td>
                                <td>{{ number_format($item->deuda, 2) }}</td>
                                <td>{{ number_format($item->deuda_dscto, 2) }}</td>
                            </tr>
                        @empty
                            <tr style="text-align: center;">
                                <td colspan="9" class="text-muted">No se encontraron registros de papeletas.</td>
                            </tr>
                        @endforelse

                        @if(count($resumenData) > 0)
                            <tr style="text-align: center; font-size:12px">
                                <td colspan="6" style="background-color:#f1f1f2"></td>
                                <td style="background-color:#f1f1f2;"><b>TOTAL</b></td>
                                <td style="font-size: 16px;"><b>{{ number_format($totalDeuda, 2) }}</b></td>
                                <td style="font-size: 16px;"><b>{{ number_format($totalDescuento, 2) }}</b></td>
                            </tr>
                            <tr style="text-align: right; font-size:12px">
                                <td colspan="7"><b>IMPORTE TOTAL:</b></td>
                                <td style="text-align: center; font-size: 16px;" colspan="2"><b>{{ number_format($total, 2) }}</b></td>
                            </tr>
                        @endif
                    </tbody>

                </table>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Products-->
    </div>
    <!--end::Post-->
</div>
@endsection
