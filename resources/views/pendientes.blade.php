@extends('layouts.cabeceraAdmin')
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
                                <span class="text-gray-800 text-primary fs-1 fw-bold me-3">Pendientes por Aprobar</span>
                            </div>
                            <!--end::Status-->
                            <!--begin::Description-->
                            <div class="d-flex flex-wrap fw-semibold mb-4 fs-5 text-gray-400">Actualizados al
                                {{ $fechaActual }}</div>
                            <!--end::Description-->
                        </div>
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
                        <form id="filtroForm" action="{{ route('Pendiente') }}" method="POST">
                            @csrf
                            <div class="d-flex flex-row">
                                <div class="w-200 mw-250px me-3">
                                    <!--begin::Select2-->
                                    <select class="form-select form-select-solid" name="estadoSeleccionado" id="estado_select"
                                        data-control="select2" data-hide-search="true"
                                        data-placeholder="Seleccione el Estado">
                                        <option></option>
                                        <option value="%" {{ $estadoSeleccionado == '%' ? 'selected' : '' }}>Todos Estados
                                        </option>
                                        @foreach ($estadosDisponibles as $estado)
                                            <option value="{{ $estado->nFlgEstado }}"
                                                {{ $estadoSeleccionado == $estado->nFlgEstado ? 'selected' : '' }}>
                                                {{ $estado->nombre_estado }}
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
                        <a href="{{ route('reporte', ['tipo' => 'reportePendientes', 'estadoSeleccionado' => $estadoSeleccionado]) }}" class="btn btn-primary" target="_blank">
                            <i class="fa-solid fa-print"></i> Imprimir
                        </a>
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
                                <th class="min-w-175px" style="text-align: center;">Nombre/Razón Social</th>
                                <th class="min-w-30px" style="text-align: center;">Asunto</th>
                                <th class=" min-w-30px" style="text-align: center;">Fecha de Registro</th>
                                <th class=" min-w-30px" style="text-align: center;">Fecha de Actualización</th>
                                <th class=" min-w-30px" style="text-align: center;">Usuario</th>
                                <th class=" min-w-30px" style="text-align: center;">Estado</th>
                                <th class=" min-w-100px" style="text-align: center;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            @if (count($Pendientes) > 0)
                                @foreach ($Pendientes as $solicitud)
                                    <tr style="text-align: center; font-size:12px">
                                        <td>{{ $solicitud->cRazonSocial ?? $solicitud->cNombres . ' ' . $solicitud->cApePate . ' ' . $solicitud->cApeMate }}
                                        </td>
                                        <td>{{ $solicitud->cAsunto }}</td>
                                        <td>{{ \Carbon\Carbon::parse($solicitud->dFechaSolicitud)->format('d/m/Y') }}</td>
                                        <td>{{ $solicitud->dFechaActualizacion ? \Carbon\Carbon::parse($solicitud->dFechaActualizacion)->format('d/m/Y') : '-' }}
                                        </td>
                                        <td>{{ $solicitud->cUsuarioActualizacion ?? '-' }}</td>
                                        <td>
                                            @if ($solicitud->nFlgEstado == 1)
                                                <div class="badge badge-light-success" style="font-size:12px">Aceptado</div>
                                            @elseif ($solicitud->nFlgEstado == 0)
                                                <div class="badge badge-light-danger" style="font-size:12px">Denegado</div>
                                            @elseif ($solicitud->nFlgEstado == 2)
                                                <div class="badge badge-light-warning" style="font-size:12px">En espera</div>
                                            @else
                                                <div class="badge badge-light-secondary" style="font-size:12px">No especificado</div>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#"
                                                class="btn btn-active-color-primary btn-sm me-1 editar-solicitud"
                                                data-bs-toggle="modal" data-bs-target="#kt_modal_add_user"
                                                data-id="{{ $solicitud->iCodPreTramite }}"
                                                data-nombre="{{ $solicitud->cRazonSocial ?? $solicitud->cNombres . ' ' . $solicitud->cApePate . ' ' . $solicitud->cApeMate }}"
                                                data-asunto="{{ $solicitud->cAsunto }}"
                                                data-fecharegistro="{{ \Carbon\Carbon::parse($solicitud->dFechaSolicitud)->format('Y-m-d') }}"
                                                data-fechaactualizacion="{{ $solicitud->dFechaActualizacion ? \Carbon\Carbon::parse($solicitud->dFechaActualizacion)->format('Y-m-d') : '' }}"
                                                data-usuario="{{ $solicitud->cUsuarioActualizacion ?? '' }}"
                                                data-estado="{{ $solicitud->nFlgEstado }}" style="padding: 0rem;">
                                                <i class="fa-solid fa-pen-to-square fs-2"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center">No se encontraron solicitudes</td>
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

    <!-- Modal para editar solicitud -->
    <div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_add_user_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Actualizar Estado de Solicitud</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body px-5 my-7">
                    <!--begin::Form-->
                    <form id="kt_modal_add_user_form" class="form" action="{{ route('Pendiente') }}" method="PUT">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="solicitud_id" id="solicitud_id">
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll"
                            data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                            data-kt-scroll-dependencies="#kt_modal_add_user_header"
                            data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">

                            <!--begin::Input group-->
                            <div class="col-xl-12 row pb-5 ">
                                <div class="col-xl-12 " style="padding: 0px 5px 0px 0px">
                                    <label class="fw-semibold fs-6 mb-2">Nombre/Razón Social</label>

                                    <input type="text" id="nombreRazonSocial"
                                        class="form-control form-control-solid mb-3 mb-lg-0" readonly />
                                </div>

                                <!--end::Input-->
                            </div>

                            <div class="col-xl-12 row pb-5 ">
                                <div class="col-xl-6 " style="padding: 0px 5px 0px 0px">
                                    <label class="fw-semibold fs-6 mb-2">Fecha de Registro</label>

                                    <input type="date" id="fechaRegistro"
                                        class="form-control form-control-solid mb-3 mb-lg-0" readonly />
                                </div>
                                <div class="col-xl-6 " style="padding: 0px 0px 0px 5px">
                                    <label class="fw-semibold fs-6 mb-2">Fecha de Actualización</label>

                                    <input type="date" id="fechaActualizacion"
                                        class="form-control form-control-solid mb-3 mb-lg-0" readonly />
                                </div>
                                <!--end::Input-->
                            </div>
                            <div class="col-xl-12 row pb-5 ">
                                <div class="col-xl-6 " style="padding: 0px 5px 0px 0px">
                                    <label class="fw-semibold fs-6 mb-2">Usuario</label>

                                    <input type="text" id="usuario"
                                        class="form-control form-control-solid mb-3 mb-lg-0" readonly />
                                </div>
                                <div class="col-xl-6 " style="padding: 0px 0px 0px 5px">
                                    <label class="required fw-semibold fs-6 mb-2">Estado</label>

                                    <select class="form-select form-select-solid" name="estado" id="estado">
                                        <option value="1">Aceptado</option>
                                        <option value="0">Denegado</option>
                                        <option value="2">En espera</option>
                                    </select>
                                </div>
                                <!--end::Input-->
                            </div>

                            <div class="col-xl-12 row pb-5 ">
                                <div class="col-xl-12 " style="padding: 0px 5px 0px 0px">
                                    <label class="fw-semibold fs-6 mb-2">Asunto</label>

                                    <textarea class="form-control bg-transparent form-control-solid" id="asunto" readonly></textarea>
                                </div>

                                <!--end::Input-->
                            </div>

                        </div>
                        <!--end::Scroll-->
                        <!--begin::Actions-->
                        <div class="text-center pt-10">
                            <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary" id="btnGuardar">
                                <span class="indicator-label">Guardar</span>
                                <span class="indicator-progress">Por favor espere...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Cuando se hace clic en el botón de editar
            $('.editar-solicitud').on('click', function() {
                // Obtener datos de los atributos data
                var id = $(this).data('id');
                var nombre = $(this).data('nombre');
                var asunto = $(this).data('asunto');
                var fechaRegistro = $(this).data('fecharegistro');
                var fechaActualizacion = $(this).data('fechaactualizacion');
                var usuario = $(this).data('usuario');
                var estado = $(this).data('estado');

                // Actualizar la acción del formulario con el ID correcto
                var actionUrl = "{{ route('Pendiente') }}";
                $('#kt_modal_add_user_form').attr('action', actionUrl);

                // Llenar los campos del formulario
                $('#solicitud_id').val(id);
                $('#nombreRazonSocial').val(nombre);
                $('#asunto').val(asunto);
                $('#fechaRegistro').val(fechaRegistro);
                $('#fechaActualizacion').val(fechaActualizacion);
                $('#usuario').val(usuario);
                $('#estado').val(estado);
            });
        });
    </script>
@endsection
