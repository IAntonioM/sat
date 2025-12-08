<div>

    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start "
        style="padding-right: calc(0px * .5); padding-left: calc(0px * .5);">
        <!--begin::Post-->
        <div class="content flex-row-fluid" id="kt_content">
            <!--begin::Products-->
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <!--begin::Card title-->
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex flex-row">
                            <div class="w-200 mw-250px me-3">
                                <!--begin::Select2-->
                                <select class="form-select form-select-solid" wire:model.live="anioSeleccionado"
                                    data-control="select2" data-hide-search="true" data-placeholder="Seleccione el Año">
                                    <option value="%">Todos los años</option>
                                    @if ($aniosDisponibles)
                                        @foreach ($aniosDisponibles as $anio)
                                            <option value="{{ $anio }}">{{ $anio }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <!--end::Select2-->
                            </div>
                            <div class="w-200 mw-250px">
                                <!--begin::Select2-->
                                <select class="form-select form-select-solid" wire:model.live="tipoTributo"
                                    data-control="select2" data-hide-search="true"
                                    data-placeholder="Seleccione el Tributo">
                                    <option value="%">Todos Tributos</option>
                                    @if ($tiposTributo)
                                        @foreach ($tiposTributo as $tributo)
                                            <option value="{{ $tributo->tipo }}">{{ $tributo->mtipo }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <!--end::Select2-->
                            </div>
                            <div>
                                <button wire:click="filtrarDeudas" class="btn btn-success" type="button">
                                    <i class="fa-solid fa-filter"></i>
                                    Filtrar</button>
                            </div>
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--end::Card title-->
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <!--begin::Add product-->
                        <a href="{{ $this->reporteUrl }}" class="btn btn-primary" target="_blank">
                            <i class="fa-solid fa-print"></i> Imprimir
                        </a>
                        <button wire:click="pagar" class="btn btn-success">
                            <i class="fa-solid fa-money-bill-1-wave"></i>
                            Pagar
                        </button>
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
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" wire:model.live="selectAll" />
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600" id="tabla_deudas">
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
                                        <td>{{ $deuda->ano }}-{{ $deuda->periodo }}</td>
                                        <td>{{ number_format($deuda->imp_insol, 2) }}</td>
                                        <td>{{ number_format($deuda->imp_reaj, 2) }}</td>
                                        <td>{{ number_format($deuda->mora, 2) }}</td>
                                        <td>{{ number_format($deuda->costo_emis, 2) }}</td>
                                        <td>{{ number_format($deuda->total, 2) }}</td>
                                        <td class="text-end">
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input check_deuda" type="checkbox"
                                                    wire:model.live="recibosSeleccionados"
                                                    value="{{ trim($codigoContribuyente) }}|{{ trim($deuda->tipo_rec) }}|{{ $deuda->ano }}-{{ $deuda->periodo }}"
                                                    data-monto="{{ $deuda->total }}" />
                                            </div>
                                        </td>
                                    </tr>
                                    @php
                                        $totalGeneral += $deuda->total;
                                    @endphp
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No se encontraron deudas con los
                                        filtros
                                        seleccionados</td>
                                </tr>
                            @endforelse

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
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @push('scripts')
        <script>
            // Reinicializar Select2 cuando el componente se actualiza
            document.addEventListener('livewire:updated', function() {
                // Reinicializar Select2 si es necesario
                $('[data-control="select2"]').select2();
            });
        </script>
    @endpush
</div>
