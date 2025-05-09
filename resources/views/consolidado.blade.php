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
                                <span class="text-gray-800 text-primary fs-1 fw-bold me-3">Deudas Consolidadas</span>
                                <!--<span class="badge badge-light-success me-auto">In Progress</span>-->
                            </div>
                            <!--end::Status-->
                            <!--begin::Description-->
                            <div class="d-flex flex-wrap fw-semibold mb-4 fs-5 text-gray-400">Deudas del Contribuyente al
                                {{ date('d/m/Y') }}</div>
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
                                    <div class="fw-bold" data-kt-countup="true" data-kt-countup-value="{{ $totalDeuda }}"
                                        data-kt-countup-prefix="S/." style="font-size:30px">0.0</div>
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

    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start "
        style="padding-right: calc(0px * .5); padding-left: calc(0px * .5);">
        <!--begin::Post-->
        <div class="content flex-row-fluid" id="kt_content">
            <!--begin::Products-->
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <form id="filtroForm" action="{{ route('consolidado') }}" method="POST">
                            @csrf
                            <div class="d-flex flex-row">
                                <div class="w-200 mw-250px me-3">
                                    <!--begin::Select2-->
                                    <select class="form-select form-select-solid" name="anio" id="anio_select"
                                        data-control="select2" data-hide-search="true" data-placeholder="Seleccione el Año">
                                        <option></option>
                                        <option value="%" {{ $anioSeleccionado == '%' ? 'selected' : '' }}>Todos los años
                                        </option>
                                        @foreach ($aniosDisponibles as $anio)
                                            <option value="{{ $anio }}"
                                                {{ $anioSeleccionado == $anio ? 'selected' : '' }}>{{ $anio }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <!--end::Select2-->
                                </div>
                                <div class="w-200 mw-250px">
                                    <!--begin::Select2-->
                                    <select class="form-select form-select-solid" name="tipo_tributo"
                                        id="tipo_tributo_select" data-control="select2" data-hide-search="true"
                                        data-placeholder="Seleccione el Tributo">
                                        <option></option>
                                        <option value="%" {{ $tipoTributo == '%' ? 'selected' : '' }}>Todos los tributos
                                        </option>
                                        @foreach ($tiposTributo as $tributo)
                                            <option value="{{ $tributo->tipo }}"
                                                {{ $tipoTributo == $tributo->tipo ? 'selected' : '' }}>
                                                {{ $tributo->mtipo }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <!--end::Select2-->
                                </div>
                                <div>
                                    <button id="btnFiltrar" class="btn btn-success" type="submit">
                                        <i class="fa-solid fa-filter"></i>
                                        Filtrar</button>
                                </div>
                            </div>
                        </form>
                        <!--end::Search-->
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <!--begin::Add product-->
                        <a href="{{ route('reporte', ['tipo' => 'reporteConsolidado', 'codigo_contribuyente' => session('codigo_contribuyente'), 'anio' => $anioSeleccionado, 'tipo_tributo' => $tipoTributo]) }}"
                            class="btn btn-primary" target="_blank"><i class="fa-solid fa-print"></i> Imprimir</a>
                        <a href="" class="btn btn-success"><i class="fa-solid fa-money-bill-1-wave"></i>Pagar</a>
                        <!--end::Add product-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5 table-bordered"
                        id="kt_ecommerce_sales_table">
                        <thead>
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0"
                                style="background-color:#f8f8f9;">

                                <th class="min-w-175px" style="text-align: center;">Tributo</th>
                                <th class="min-w-30px" style="text-align: center;">Año</th>
                                <th class=" min-w-30px" style="text-align: center;">Imp. Insoluto</th>
                                <th class=" min-w-30px" style="text-align: center;">Imp. Reajuste</th>
                                <th class=" min-w-30px" style="text-align: center;">Mora</th>
                                <th class=" min-w-30px" style="text-align: center;">Cos. de Emisión</th>
                                <th class=" min-w-100px" style="text-align: center;">Total</th>
                                <th class="w-20px pe-2">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid ">
                                        <input class="form-check-input" type="checkbox" data-kt-check="true"
                                            data-kt-check-target="#kt_ecommerce_sales_table .form-check-input"
                                            value="1" />
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            @php
                                $totalGeneral = 0;
                                $anioActual = null;
                            @endphp
                            @forelse($deudas as $anio => $deudasAnio)
                                <tr>
                                    <td colspan="8" style="background-color: #f1faff;color:#009ef7">
                                        <i class="fa-solid fa-calendar-days" style="color:#009ef7"></i>
                                        <b>{{ $anio }}</b>
                                    </td>
                                </tr>

                                @foreach ($deudasAnio as $deuda)
                                    <tr style="text-align: center; font-size:12px">
                                        <td>
                                            <div class="badge {{ !is_null($deuda->tipo) && strpos($deuda->tipo, '02.') !== false ? 'badge-light-success' : 'badge-light-danger' }}"
                                                style="font-size:12px">
                                                {{ $deuda->mtipo }}
                                            </div>
                                        </td>
                                        <td>{{ $deuda->año }}</td>
                                        <td>{{ number_format($deuda->imp_insol, 2) }}</td>
                                        <td>{{ number_format($deuda->imp_reaj, 2) }}</td>
                                        <td>{{ number_format($deuda->mora, 2) }}</td>
                                        <td>{{ number_format($deuda->costo_emis, 2) }}</td>
                                        <td>{{ number_format($deuda->total, 2) }}</td>
                                        <td class="text-end">
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input checkbox-recibo" type="checkbox"
                                                    value="{{ $deuda->idrecibo }}" data-id="{{ $deuda->idrecibo }}" />
                                            </div>
                                        </td>
                                    </tr>
                                    @php
                                        $totalGeneral += $deuda->total;
                                    @endphp
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No se encontraron deudas con los filtros
                                                seleccionados</td>
                                        </tr>
                                    @endforelse
                                @endforeach
                                @if ($totalGeneral > 0)
                                    <tr style="text-align: center; font-size:12px">
                                        <td style="background-color:#f1f1f2"></td>
                                        <td style="background-color:#f1f1f2"></td>
                                        <td style="background-color:#f1f1f2"></td>
                                        <td style="background-color:#f1f1f2"></td>
                                        <td style="background-color:#f1f1f2"></td>
                                        <td style="background-color:#f1f1f2;"><b>TOTAL</b></td>
                                        <td style="font-size: 16px;"><b>{{ number_format($totalGeneral, 2) }}</b></td>
                                        <td style="background-color:#f1f1f2;"></td>
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
    @push('scripts')
        <script src="{{ asset('js/consolidadoJS.js') }}"></script>
    @endpush
