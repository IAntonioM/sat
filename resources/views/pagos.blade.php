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
                            <span class="text-gray-800 text-primary fs-1 fw-bold me-3">Mis Pagos</span>
                        </div>
                        <!--end::Status-->
                        <!--begin::Description-->
                        <div class="d-flex flex-wrap fw-semibold mb-4 fs-5 text-gray-400">Pagos del Contribuyente al {{ $fechaActual }}</div>
                        <!--end::Description-->
                    </div>
                    <div class="d-flex mb-4">
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3 badge-light-primary">
                            <div class="fw-semibold fs-6 text-gray-400">Su Total Pagado es:</div>
                            <div class="d-flex align-items-center">
                                <div class="fw-bold" data-kt-countup="true" data-kt-countup-value="{{ $totalPagado }}" data-kt-countup-prefix="S/." style="font-size:30px">0</div>
                            </div>
                        </div>
                    </div>
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
                    <form action="{{ route('Pagos') }}" method="GET" id="filtroForm">
                        <div class="d-flex align-items-center">
                            <div class="w-200 mw-250px" style="padding-right: 10px;">
                                <!--begin::Select2-->
                                <select class="form-select form-select-solid" name="anio" id="anio" data-control="select2" data-hide-search="true" data-placeholder="Seleccione el Año" onchange="document.getElementById('filtroForm').submit()">
                                    <option></option>
                                    <option value="%" {{ $anioSeleccionado == '%' ? 'selected' : '' }}>Todos los años</option>
                                    @foreach($aniosDisponibles as $anio)
                                        <option value="{{ $anio->año }}" {{ $anioSeleccionado == $anio->año ? 'selected' : '' }}>{{ $anio->año }}</option>
                                    @endforeach
                                </select>
                                <!--end::Select2-->
                            </div>
                            <div class="w-200 mw-250px">
                                <!--begin::Select2-->
                                <select class="form-select form-select-solid" name="tipotributo" id="tipotributo" data-control="select2" data-hide-search="true" data-placeholder="Seleccione el Tributo" onchange="document.getElementById('filtroForm').submit()">
                                    <option></option>
                                    <option value="%" {{ $tipoTributo == '%' ? 'selected' : '' }}>Todos tributos</option>
                                    @foreach($tiposTributo as $tributo)
                                        <option value="{{ $tributo->tipo }}" {{ $tipoTributo == $tributo->tipo ? 'selected' : '' }}>{{ $tributo->tipo_d }}</option>
                                    @endforeach
                                </select>
                                <!--end::Select2-->
                            </div>
                        </div>
                    </form>
                    <!--end::Search-->
                </div>
                <!--end::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                    <!--begin::Add product-->
                    <a href="#" class="btn btn-primary" onclick="window.print()"><i class="fa-solid fa-print"></i> Imprimir</a>
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
                            <th class="min-w-175px" style="text-align: center;">Tributo</th>
                            <th class="min-w-30px" style="text-align: center;">Año</th>
                            <th class="min-w-30px" style="text-align: center;">Imp. Insoluto</th>
                            <th class="min-w-30px" style="text-align: center;">Imp. Reajuste</th>
                            <th class="min-w-30px" style="text-align: center;">Mora</th>
                            <th class="min-w-30px" style="text-align: center;">Cos. de Emisión</th>
                            <th class="min-w-100px" style="text-align: center;">Total</th>
                            <th class="min-w-100px" style="text-align: center;">Fecha de Pago</th>
                            <th class="min-w-100px" style="text-align: center;">N° Recibo</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @php
                            $pagosAgrupados = [];
                            $totalesPorAnio = [];

                            // Agrupar pagos por año
                            foreach ($pagos as $pago) {
                                $anio = explode('-', $pago->ANIO)[0];
                                if (!isset($pagosAgrupados[$anio])) {
                                    $pagosAgrupados[$anio] = [];
                                }
                                $pagosAgrupados[$anio][] = $pago;

                                // Calcular totales por año
                                if (!isset($totalesPorAnio[$anio])) {
                                    $totalesPorAnio[$anio] = 0;
                                }
                                $totalesPorAnio[$anio] += floatval($pago->TOTAL);
                            }

                            // Ordenar años en orden descendente
                            krsort($pagosAgrupados);
                        @endphp

                        @foreach($pagosAgrupados as $anio => $pagosPorAnio)
                            <tr>
                                <td colspan="9" style="background-color: #f1faff;color:#009ef7">
                                    <i class="fa-solid fa-calendar-days" style="color:#009ef7"></i> <b>{{ $anio }}</b>
                                </td>
                            </tr>

                            @foreach($pagosPorAnio as $pago)
                                @php
                                    $badgeClass = $pago->TIPO_D == "IMP.PREDIAL" ? "badge-light-success" : "badge-light-danger";
                                @endphp
                                <tr style="text-align: center; font-size:12px">
                                    <td>
                                        <div class="{{ $badgeClass }}" style="font-size:12px">
                                            {{ $pago->TIPO_D }}
                                        </div>
                                    </td>
                                    <td>{{ $pago->ANIO }}</td>
                                    <td>{{ number_format(floatval($pago->IMP_INSOL), 2) }}</td>
                                    <td>0.00</td>
                                    <td>{{ number_format(floatval($pago->MORA), 2) }}</td>
                                    <td>{{ number_format(floatval($pago->COSTO_EMIS), 2) }}</td>
                                    <td>{{ number_format(floatval($pago->TOTAL), 2) }}</td>
                                    <td>{{ isset($pago->FECHA_PAGO) ? $pago->FECHA_PAGO : '' }}</td>
                                    <td>{{ isset($pago->NRO_RECIBO) ? $pago->NRO_RECIBO : '' }}</td>
                                </tr>
                            @endforeach

                            <tr style="text-align: center; font-size:12px">
                                <td style="background-color:#f1f1f2"></td>
                                <td style="background-color:#f1f1f2"></td>
                                <td style="background-color:#f1f1f2"></td>
                                <td style="background-color:#f1f1f2"></td>
                                <td style="background-color:#f1f1f2"></td>
                                <td style="background-color:#f1f1f2;"><b>TOTAL</b></td>
                                <td style="font-size: 16px;"><b>{{ number_format($totalesPorAnio[$anio], 2) }}</b></td>
                                <td style="background-color:#f1f1f2;"></td>
                                <td style="background-color:#f1f1f2;"></td>
                            </tr>
                        @endforeach

                        @if(count($pagos) == 0)
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <div class="alert alert-info">
                                        No se encontraron registros de pagos con los filtros seleccionados.
                                    </div>
                                </td>
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
