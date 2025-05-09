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
                                <span class="text-gray-800 text-primary fs-1 fw-bold me-3">Usuarios</span>
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
                        <form id="filtroForm" action="{{ route('UsuariosAdmin') }}" method="POST">
                            @csrf
                            <div class="d-flex flex-row">
                                <div class="w-200 mw-250px me-3">
                                    <!--begin::Select2-->
                                    <select class="form-select form-select-solid" name="estadoSeleccionado" id="anio_select"
                                        data-control="select2" data-hide-search="true"
                                        data-placeholder="Seleccione el Estado">
                                        <option></option>
                                        <option value="%" {{ $estadoSeleccionado == '%' ? 'selected' : '' }}>Todos Los
                                            Estados
                                        </option>
                                        @foreach ($estadosDisponibles as $estado)
                                            <option value="{{ $estado->vestado_cuenta }}"
                                                {{ $estadoSeleccionado == $estado->vestado_cuenta ? 'selected' : '' }}>
                                                {{ $estado->nombre_estado }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <!--end::Select2-->
                                </div>
                                <div class="w-200 mw-250px">
                                    <!--begin::Select2-->
                                    <select class="form-select form-select-solid" name="tipoAdministrador"
                                        id="tipo_admin_select" data-control="select2" data-hide-search="true"
                                        data-placeholder="Seleccione el Tributo">
                                        <option></option>
                                        <option value="%" {{ $tipoAdministrador == '%' ? 'selected' : '' }}>Todos los
                                            Roles
                                        </option>
                                        @foreach ($tiposAdmins as $tipoAdmin)
                                            <option value="{{ $tipoAdmin->vestado }}"
                                                {{ $tipoAdministrador == $tipoAdmin->vestado ? 'selected' : '' }}>
                                                {{ $tipoAdmin->nombre_tipo_admin }}
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
                        <a href="{{ route('reporte', [
                            'tipo' => 'reporteUsuariosAdmin',
                            'tipoAdministrador' => $tipoAdministrador,
                            'estadoSeleccionado' => $estadoSeleccionado,
                        ]) }}"
                            class="btn btn-primary" target="_blank">
                            <i class="fa-solid fa-print"></i> Imprimir
                        </a>

                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_add_user">
                            <i class="fa-solid fa-user-plus"></i> Nuevo Usuario
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
                                <th class="min-w-175px" style="text-align: center;">Usuario</th>
                                <th class="min-w-30px" style="text-align: center;">Apellidos y Nombres</th>
                                <th class=" min-w-30px" style="text-align: center;">Fecha de Registro</th>
                                <th class=" min-w-30px" style="text-align: center;">Tipo de Administrador</th>
                                <th class=" min-w-30px" style="text-align: center;">Estado</th>
                                <th class=" min-w-100px" style="text-align: center;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600" id="tabla_usuarios">
                            @forelse($UsuariosList as $usuarioItem)
                                <tr style="text-align: center; font-size:12px">
                                    <td>{{ $usuarioItem->vusuario }}</td>
                                    <td>{{ trim($usuarioItem->vpater . ' ' . $usuarioItem->vmater . ' ' . $usuarioItem->vnombre) }}
                                    </td>
                                    <td>{{ $usuarioItem->dfecregist ? date('d/m/Y', strtotime($usuarioItem->dfecregist)) : '' }}
                                    <td>{{ $usuarioItem->tipo_admin ?? 'N/A' }}</td>
                                    <td>{{ $usuarioItem->estado_nombre ?? 'N/A' }}</td>
                                    <td>
                                        <a href="#" class="btn btn-active-color-primary btn-sm me-1 editar-usuario"
                                            style="padding: 0rem;" data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_edit_user" data-id="{{ $usuarioItem->vnrodoc }}"
                                            data-nombres="{{ $usuarioItem->vnombre }}" data-usuario="{{ $usuarioItem->vusuario }}"
                                            data-apellidos="{{ trim($usuarioItem->vpater . ' ' . $usuarioItem->vmater) }}"
                                            data-fecha="{{ $usuarioItem->dfecregist }}" data-tipo="{{ $usuarioItem->vestado }}"
                                            data-estado="{{ $usuarioItem->vestado_cuenta }}">
                                            <i class="fa-solid fa-pen-to-square fs-2"></i>
                                        </a>

                                        <a href="#" class="btn btn-active-color-danger btn-sm me-1 editar-usuario"
                                            style="padding: 0rem;" data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_delete_user" data-id="{{ $usuarioItem->vnrodoc }}"
                                            data-nombres="{{ $usuarioItem->vnombre }}" data-usuario="{{ $usuarioItem->vusuario }}"
                                            data-apellidos="{{ trim($usuarioItem->vpater . ' ' . $usuario->vmater) }}"
                                            data-fecha="{{ $usuarioItem->dfecregist }}" data-tipo="{{ $usuarioItem->vestado }}"
                                            data-estado="{{ $usuarioItem->vestado_cuenta }}">
                                            <i class="fa-solid fa-trash fs-2"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No se encontraron usuarios con los filtros
                                        seleccionados</td>
                                </tr>
                            @endforelse
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

    <div class="modal fade" id="kt_modal_edit_user" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_edit_user_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Editar Usuario</h2>
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
                    <form id="kt_modal_edit_user_form" class="form" action="{{ route('actualizarUsuario') }}"
                        method="POST">
                        @csrf
                        <input type="hidden" name="user_id" id="edit_user_id">
                        <input type="hidden" name="nrdocActual" id="nrdocActual_">
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_edit_user_scroll"
                            data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                            data-kt-scroll-dependencies="#kt_modal_edit_user_header"
                            data-kt-scroll-wrappers="#kt_modal_edit_user_scroll" data-kt-scroll-offset="300px">

                            <!--begin::Input group-->
                            <div class="col-xl-12 row pb-5 ">
                                <div class="col-xl-6 " style="padding: 0px 5px 0px 0px">
                                    <label class="required fw-semibold fs-6 mb-2">Apellidos</label>

                                    <input type="text" name="apellidos" id="edit_apellidos"
                                        class="form-control form-control-solid mb-3 mb-lg-0" value="{{ old('apellidos') }}" required />
                                    @error('apellidos')
                                        <div style="color: #d12d2d">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-xl-6 " style="padding: 0px 0px 0px 5px">
                                    <label class="required fw-semibold fs-6 mb-2">Nombres</label>

                                    <input type="text" name="nombres" id="edit_nombres"
                                        class="form-control form-control-solid mb-3 mb-lg-0" required />
                                    @error('nombres')
                                        <div style="color: #d12d2d">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!--end::Input-->
                            </div>

                            <div class="col-xl-12 row pb-5 ">
                                <div class="col-xl-6 " style="padding: 0px 5px 0px 0px">
                                    <label class="required fw-semibold fs-6 mb-2">Usuario</label>

                                    <input type="text" name="usuario" id="edit_usuario"
                                        class="form-control form-control-solid mb-3 mb-lg-0" required />
                                    @error('usuario')
                                        <div style="color: #d12d2d">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-xl-6 " style="padding: 0px 0px 0px 5px">
                                    <label class="fw-semibold fs-6 mb-2">Password</label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="edit_password"
                                            class="form-control form-control-solid"
                                            placeholder="Dejar vacío para mantener la contraseña actual" />
                                        <span class="input-group-text">
                                            <i class="ki-duotone ki-eye-slash toggle-password fs-2"
                                                data-target="edit_password">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                            </i>
                                        </span>
                                        @error('password')
                                            <div style="color: #d12d2d">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <!--end::Input-->
                            </div>
                            <div class="col-xl-12 row pb-5 ">
                                <div class="col-xl-6 " style="padding: 0px 5px 0px 0px">
                                    <label class="required fw-semibold fs-6 mb-2">Fecha de Registro</label>

                                    <input type="date" name="fechaRegistro" id="edit_fechaRegistro"
                                        class="form-control form-control-solid mb-3 mb-lg-0" required />
                                    @error('fechaRegistro')
                                        <div style="color: #d12d2d">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-xl-6 " style="padding: 0px 0px 0px 5px">
                                    <label class="required fw-semibold fs-6 mb-2">Estado</label>

                                    <select name="estado" id="edit_estado" class="form-select form-select-solid"
                                        data-control="select2" data-hide-search="true"
                                        data-placeholder="Seleccione el Estado" required>
                                        <option value="1">Activo</option>
                                        <option value="0">Desactivado</option>
                                    </select>
                                    @error('estado')
                                        <div style="color: #d12d2d">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!--end::Input-->
                            </div>

                            <div class="mb-5">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-5">Tipo de Usuario</label>
                                <!--end::Label-->
                                <!--begin::Roles-->
                                <!--begin::Input row-->
                                <div class="d-flex fv-row">
                                    <!--begin::Radio-->
                                    <div class="form-check form-check-custom form-check-solid">
                                        <!--begin::Input-->
                                        <input class="form-check-input me-3" name="tipoAdministrador" type="radio"
                                            value="1" id="edit_tipoAdministrador_0" />
                                        <!--end::Input-->
                                        <!--begin::Label-->
                                        <label class="form-check-label" for="edit_tipoAdministrador_0">
                                            <div class="fw-bold text-gray-800">Moderador</div>

                                        </label>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Radio-->
                                </div>
                                <div class='separator separator-dashed my-5'></div>
                                <div class="d-flex fv-row">
                                    <!--begin::Radio-->
                                    <div class="form-check form-check-custom form-check-solid">
                                        <!--begin::Input-->
                                        <input class="form-check-input me-3" name="tipoAdministrador" type="radio"
                                            value="0" id="edit_tipoAdministrador_1" />
                                        <!--end::Input-->
                                        <!--begin::Label-->
                                        <label class="form-check-label" for="edit_tipoAdministrador_1">
                                            <div class="fw-bold text-gray-800">Administrador</div>

                                        </label>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Radio-->
                                </div>
                                @error('tipoAdministrador')
                                    <div style="color: #d12d2d">{{ $message }}</div>
                                @enderror

                                <div class='separator separator-dashed my-5'></div>

                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Scroll-->
                        <!--begin::Actions-->
                        <div class="text-center pt-10">
                            <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">Actualizar</span>
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

    <!-- Modal Nuevo Usuario -->
    <div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true" >
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_add_user_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Nuevo Usuario</h2>
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
                    <form id="kt_modal_add_user_form" class="form" action="{{ route('crearUsuario') }}"
                        method="POST">
                        @csrf
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll"
                            data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                            data-kt-scroll-dependencies="#kt_modal_add_user_header"
                            data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">

                            <!--begin::Input group-->
                            <div class="col-xl-12 row pb-5 ">
                                <div class="col-xl-6 " style="padding: 0px 5px 0px 0px">
                                    <label class="required fw-semibold fs-6 mb-2">Apellidos</label>

                                    <input type="text" name="apellidos"
                                        class="form-control form-control-solid mb-3 mb-lg-0" required />
                                    @error('apellidos')
                                        <div style="color: #d12d2d">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-xl-6 " style="padding: 0px 0px 0px 5px">
                                    <label class="required fw-semibold fs-6 mb-2">Nombres</label>

                                    <input type="text" name="nombres"
                                        class="form-control form-control-solid mb-3 mb-lg-0" required />
                                    @error('nombres')
                                        <div style="color: #d12d2d">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!--end::Input-->
                            </div>

                            <div class="col-xl-12 row pb-5 ">
                                <div class="col-xl-6 " style="padding: 0px 5px 0px 0px">
                                    <label class="required fw-semibold fs-6 mb-2">Usuario</label>

                                    <input type="text" name="usuario"
                                        class="form-control form-control-solid mb-3 mb-lg-0" required />
                                    @error('usuario')
                                        <div style="color: #d12d2d">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-xl-6 " style="padding: 0px 0px 0px 5px">
                                    <label class="required fw-semibold fs-6 mb-2">Password</label>

                                    <input type="password" name="password"
                                        class="form-control form-control-solid mb-3 mb-lg-0" required />
                                    @error('password')
                                        <div style="color: #d12d2d">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!--end::Input-->
                            </div>
                            <div class="col-xl-12 row pb-5 ">
                                <div class="col-xl-6 " style="padding: 0px 5px 0px 0px">
                                    <label class="required fw-semibold fs-6 mb-2">Fecha de Registro</label>

                                    <input type="date" name="fechaRegistro"
                                        class="form-control form-control-solid mb-3 mb-lg-0" value="{{ date('Y-m-d') }}"
                                        required />
                                    @error('fechaRegistro')
                                        <div style="color: #d12d2d">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-xl-6 " style="padding: 0px 0px 0px 5px">
                                    <label class="required fw-semibold fs-6 mb-2">Estado</label>

                                    <select name="estado" class="form-select form-select-solid" data-control="select2"
                                        data-hide-search="true" data-placeholder="Seleccione el Estado" required>
                                        <option value="1" selected>Activo</option>
                                        <option value="0">Desactivado</option>
                                    </select>
                                    @error('estado')
                                        <div style="color: #d12d2d">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!--end::Input-->
                            </div>

                            <div class="mb-5">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-5">Tipo de Usuario</label>
                                <!--end::Label-->
                                <!--begin::Roles-->
                                <!--begin::Input row-->
                                <div class="d-flex fv-row">
                                    <!--begin::Radio-->
                                    <div class="form-check form-check-custom form-check-solid">
                                        <!--begin::Input-->
                                        <input class="form-check-input me-3" name="tipoAdministrador" type="radio"
                                            value="0" id="kt_modal_update_role_option_0" checked='checked' />
                                        <!--end::Input-->
                                        <!--begin::Label-->
                                        <label class="form-check-label" for="kt_modal_update_role_option_0">
                                            <div class="fw-bold text-gray-800">Moderador</div>

                                        </label>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Radio-->
                                </div>
                                <div class='separator separator-dashed my-5'></div>
                                <div class="d-flex fv-row">
                                    <!--begin::Radio-->
                                    <div class="form-check form-check-custom form-check-solid">
                                        <!--begin::Input-->
                                        <input class="form-check-input me-3" name="tipoAdministrador" type="radio"
                                            value="1" id="kt_modal_update_role_option_1" />
                                        <!--end::Input-->
                                        <!--begin::Label-->
                                        <label class="form-check-label" for="kt_modal_update_role_option_1">
                                            <div class="fw-bold text-gray-800">Administrador</div>

                                        </label>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Radio-->
                                </div>
                                @error('tipoAdministrador')
                                    <div style="color: #d12d2d">{{ $message }}</div>
                                @enderror

                                <div class='separator separator-dashed my-5'></div>

                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Scroll-->
                        <!--begin::Actions-->
                        <div class="text-center pt-10">
                            <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">
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

    <!-- Modal Eliminar Usuario -->
    <div class="modal fade" id="kt_modal_delete_user" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-500px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold">Eliminar Usuario</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <div class="modal-body text-center py-8">
                    <p class="fs-5 fw-semibold text-gray-800 mb-0">¿Está seguro que desea eliminar este usuario?</p>
                    <p class="text-gray-600">Esta acción no se puede deshacer.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <form id="form-eliminar-usuario" action="{{ route('eliminarUsuario') }}" method="POST"
                        class="d-inline">
                        @csrf
                        <input type="hidden" name="user_id" id="delete_user_id">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}">
    @push('scripts')
    @endpush --}}
@endsection
