
<div class="card-body" style="max-height: 800px; overflow-y: auto;">
    <div id="printable-area">
        @if ($visible)
            <!--begin::Title-->
            <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-6">
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <!--begin::Heading-->
                    <h2 class="fw-semibold me-3 my-1">{{ $padre->asunto ?? 'Asunto no disponible' }}</h2>
                    <!--end::Heading-->
                </div>
                <div class="d-flex">
                    <!--begin::Print-->
                    <a href="javascript:void(0)" onclick="printCardBody()"
                        class="btn btn-sm btn-icon btn-light btn-active-light-primary me-2"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Imprimir">
                        <i class="ki-duotone ki-printer fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                            <span class="path5"></span>
                        </i>
                    </a>
                    <!--end::Print-->
                </div>
            </div>
            <!--end::Title-->

            <!--begin::Message accordion-->
            <div data-kt-inbox-message="message_wrapper">
                <!--begin::Message header-->
                <div class="d-flex justify-content-between align-items-start cursor-pointer mb-4"
                     data-kt-inbox-message="header">

                    <!--begin::Author section-->
                    <div class="d-flex align-items-center flex-grow-1">
                        <!--begin::Avatar-->
                        <div class="symbol symbol-50 me-4">
                            <span class="symbol-label bg-light-primary">
                                <i class="ki-duotone ki-profile-circle fs-2 text-primary">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                            </span>
                        </div>
                        <!--end::Avatar-->

                        <!--begin::Author info-->
                        <div class="d-flex flex-column">
                            <!--begin::Name-->
                            <a href="#" class="fw-bold text-dark text-hover-primary mb-1">
                                {{ $padre->nombre_emisor ?? 'Nombre Emisor no Disponible' }}
                            </a>
                            <!--end::Name-->

                            <!--begin::Time ago-->
                            <div class="d-flex align-items-center">
                                <i class="ki-duotone ki-abstract-8 fs-7 text-success me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <span class="text-muted fw-semibold fs-7">
                                    {{ \Carbon\Carbon::parse($padre->fecha_creacion)->locale('es')->diffForHumans() }}
                                </span>
                            </div>
                            <!--end::Time ago-->
                        </div>
                        <!--end::Author info-->
                    </div>
                    <!--end::Author section-->

                    <!--begin::Actions section-->
                    <div class="d-flex flex-column align-items-end">
                        <!--begin::Date-->
                        <span class="fw-semibold text-muted mb-2">
                            {{ \Carbon\Carbon::parse($padre->fecha_creacion)->locale('es')->translatedFormat('d M Y, h:i a') }}
                        </span>
                        <!--end::Date-->

                        <!--begin::Star-->
                        <a href="#"
                           wire:click.prevent="marcarFavorito('{{ $padre->nu_emi }}')"
                           class="btn btn-sm btn-icon btn-clear btn-active-light-primary"
                           data-bs-toggle="tooltip" data-bs-placement="top" title="Favorito">
                            <i class="ki-duotone ki-star fs-2 m-0 {{ $padre->flag_favorito == 1 ? 'text-warning' : '' }}">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </a>
                        <!--end::Star-->
                    </div>
                    <!--end::Actions section-->
                </div>
                <!--end::Message header-->

                <!--begin::Message content-->
                <div class="collapse fade show" data-kt-inbox-message="message">
                    <div class="py-5">
                        <div class="text-gray-800 fs-6 fw-normal pt-1">
                            {{ $padre->contenido ?? '' }}
                        </div>
                @if (!empty($padre->anexos))
                    @php
                        $anexos = json_decode($padre->anexos, true);
                    @endphp

                    <div class="separator separator-dashed my-7"></div>

                    <div class="card card-flush bg-light-primary">
                        <div class="card-header pt-5 pb-3">
                            <div class="card-title d-flex align-items-center">
                                <i class="ki-duotone ki-folder-down fs-2 text-primary me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <h6 class="fw-bold text-gray-800 mb-0">Archivos Adjuntos</h6>
                                <span class="badge badge-light-primary ms-3">{{ count($anexos) }}</span>
                            </div>
                        </div>

                        <div class="card-body pt-0 pb-5">
                            <div class="row g-3">
                                @foreach ($anexos as $index => $anexo)
                                    <div class="col-12">
                                        <div class="card card-flush border border-gray-300 hover-elevate-up">
                                            <div class="card-body d-flex align-items-center py-4 px-5">
                                                <!-- Icono del archivo -->
                                                <div class="symbol symbol-45 me-4">
                                                    <div
                                                        class="symbol-label bg-light-{{ $anexo['extension_tipo'] === 'pdf' ? 'danger' : ($anexo['extension_tipo'] === 'docx' || $anexo['extension_tipo'] === 'doc' ? 'primary' : ($anexo['extension_tipo'] === 'xlsx' || $anexo['extension_tipo'] === 'xls' ? 'success' : 'info')) }}">
                                                        @if (in_array(strtolower($anexo['extension_tipo']), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                            <i class="ki-duotone ki-picture fs-2 text-info">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                        @elseif(strtolower($anexo['extension_tipo']) === 'pdf')
                                                            <i class="ki-duotone ki-file-sheet fs-2 text-danger">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                        @elseif(in_array(strtolower($anexo['extension_tipo']), ['doc', 'docx']))
                                                            <i class="ki-duotone ki-document fs-2 text-primary">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                        @elseif(in_array(strtolower($anexo['extension_tipo']), ['xls', 'xlsx']))
                                                            <i class="ki-duotone ki-file-sheet fs-2 text-success">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                        @elseif(in_array(strtolower($anexo['extension_tipo']), ['zip', 'rar', '7z']))
                                                            <i class="ki-duotone ki-folder-down fs-2 text-warning">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                        @else
                                                            <i class="ki-duotone ki-file fs-2 text-info">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                        @endif
                                                    </div>
                                                </div>

                                                <!-- Información del archivo -->
                                                <div class="flex-grow-1 me-3">
                                                    <div class="text-gray-800 fw-bold fs-6 mb-1">
                                                        {{ $anexo['nombre_archivo'] }}
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <span
                                                            class="badge badge-light-{{ $anexo['extension_tipo'] === 'pdf' ? 'danger' : ($anexo['extension_tipo'] === 'docx' || $anexo['extension_tipo'] === 'doc' ? 'primary' : ($anexo['extension_tipo'] === 'xlsx' || $anexo['extension_tipo'] === 'xls' ? 'success' : 'info')) }} fs-7 fw-bold me-2">
                                                            {{ strtoupper($anexo['extension_tipo']) }}
                                                        </span>
                                                        @if (isset($anexo['tamaño_archivo']))
                                                            <span
                                                                class="text-muted fs-7">{{ $anexo['tamaño_archivo'] }}</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <!-- Botones de acción -->
                                                <div class="d-flex align-items-center">
                                                    @if (in_array(strtolower($anexo['extension_tipo']), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf']))
                                                        <!-- Botón Ver en Modal (para imágenes y PDF) -->
                                                        <button type="button"
                                                            class="btn btn-sm btn-icon btn-light-primary me-2"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#fileModal{{ $index }}"
                                                            data-bs-toggle-tooltip="tooltip" title="Ver en modal">
                                                            <i class="ki-duotone ki-eye fs-5">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                            </i>
                                                        </button>
                                                    @endif

                                                    <!-- Botón Ver en nueva pestaña -->
                                                    <a href="{{ route('ver.archivoCasillaElectronica', $anexo['url_archivo']) }}"
                                                        target="_blank"
                                                        class="btn btn-sm btn-icon btn-light-info me-2"
                                                        data-bs-toggle="tooltip" title="Abrir en nueva pestaña">
                                                        <i class="ki-duotone ki-entrance-right fs-5">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </a>

                                                    <!-- Botón Descargar -->
                                                    <a href="{{ route('ver.archivoCasillaElectronica', $anexo['url_archivo']) }}"
                                                        download class="btn btn-sm btn-icon btn-light-success"
                                                        data-bs-toggle="tooltip" title="Descargar">
                                                        <i class="ki-duotone ki-down fs-5">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Modales para visualización de archivos -->
                    @foreach ($anexos as $index => $anexo)
                        @if (in_array(strtolower($anexo['extension_tipo']), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf']))
                            <div class="modal fade" id="fileModal{{ $index }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog modal-xl modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title d-flex align-items-center">
                                                @if (in_array(strtolower($anexo['extension_tipo']), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                    <i class="ki-duotone ki-picture fs-2 text-info me-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                @else
                                                    <i class="ki-duotone ki-file-sheet fs-2 text-danger me-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                @endif
                                                {{ $anexo['nombre_archivo'] }}
                                            </h5>
                                            <div class="btn-group">
                                                <a href="{{ route('ver.archivoCasillaElectronica', $anexo['url_archivo']) }}"
                                                    target="_blank" class="btn btn-sm btn-light-primary me-2"
                                                    data-bs-toggle="tooltip" title="Abrir en nueva pestaña">
                                                    <i class="ki-duotone ki-entrance-right fs-5">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                    Abrir
                                                </a>
                                                <a href="{{ route('ver.archivoCasillaElectronica', $anexo['url_archivo']) }}"
                                                    download class="btn btn-sm btn-light-success me-2"
                                                    data-bs-toggle="tooltip" title="Descargar">
                                                    <i class="ki-duotone ki-down fs-5">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                    Descargar
                                                </a>
                                                <button type="button" class="btn btn-sm btn-light-secondary"
                                                    data-bs-dismiss="modal">
                                                    <i class="ki-duotone ki-cross fs-5">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                    Cerrar
                                                </button>
                                            </div>
                                        </div>
                                        <div class="modal-body p-0">
                                            @if (in_array(strtolower($anexo['extension_tipo']), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                <!-- Vista previa de imagen -->
                                                <div class="text-center bg-light p-5">
                                                    <img src="{{ route('ver.archivoCasillaElectronica', $anexo['url_archivo']) }}"
                                                        alt="{{ $anexo['nombre_archivo'] }}"
                                                        class="img-fluid rounded shadow-sm"
                                                        style="max-height: 70vh; object-fit: contain;">
                                                </div>
                                            @elseif(strtolower($anexo['extension_tipo']) === 'pdf')
                                                <!-- Vista previa de PDF -->
                                                <embed
                                                    src="{{ route('ver.archivoCasillaElectronica', $anexo['url_archivo']) }}"
                                                    type="application/pdf" width="100%" height="600px"
                                                    class="rounded">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif

            </div>
            <!--end::Message content-->
        </div>
        @if (!empty($hijos) && count($hijos))
            @foreach ($hijos as $hijo)
                <!--end::Message accordion-->
                <div class="separator my-6"></div>
                <!--begin::Message accordion-->
                <div data-kt-inbox-message="message_wrapper">
                    <!--begin::Message header-->
                    <div class="d-flex flex-wrap gap-2 flex-stack cursor-pointer" data-kt-inbox-message="header">
                        <!--begin::Author-->
                        <div class="d-flex align-items-center">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-50 me-4">
                                <span class="symbol-label bg-light-primary">
                                    <i class="ki-duotone ki-profile-circle fs-2 text-primary">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </span>
                            </div>
                            <!--end::Avatar-->
                            <div class="pe-5">
                                <!--begin::Author details-->
                                <div class="d-flex align-items-center flex-wrap gap-1">
                                    <a href="#"
                                        class="fw-bold text-dark text-hover-primary">{{ $hijo->nombre_emisor ?? 'Nombres Emisor no Disponible' }}</a>
                                    <i class="ki-duotone ki-abstract-8 fs-7 text-success mx-3">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <span
                                        class="text-muted fw-bold">{{ \Carbon\Carbon::parse($hijo->fecha_creacion)->locale('es')->diffForHumans() }}</span>
                                </div>
                                <!--end::Author details-->
                                <!--begin::Message details-->
                                <div class="d-none" data-kt-inbox-message="details">
                                    <span class="text-muted fw-semibold">to me</span>
                                    <!--begin::Menu toggle-->
                                    <a href="#" class="me-1" data-kt-menu-trigger="click"
                                        data-kt-menu-placement="bottom-start">
                                        <i class="ki-duotone ki-down fs-5 m-0"></i>
                                    </a>
                                    <!--end::Menu toggle-->
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-300px p-4"
                                        data-kt-menu="true">
                                        <!--begin::Table-->
                                        <table class="table mb-0">
                                            <tbody>
                                                <tr>
                                                    <td class="w-75px text-muted">From</td>
                                                    <td>Emma Bold</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">Date</td>
                                                    <td>25 Oct 2023, 9:23 pm</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">Subject</td>
                                                    <td>Trip Reminder. Thank you for flying with us!</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">Reply-to</td>
                                                    <td>emma@intenso.com</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!--end::Menu-->
                                </div>
                                <!--end::Message details-->
                                <!--begin::Preview message-->
                                <div class="text-muted fw-semibold mw-450px" data-kt-inbox-message="preview">
                                    {{ $hijo->contenido ?? '' }}
                                    {{-- Jornalists call
                            this
                            critical, introductory section the "Lede," and when bridge properly executed.... --}}
                                </div>
                                <!--end::Preview message-->
                            </div>
                        </div>
                        <!--end::Author-->
                        <!--begin::Actions-->
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <!--begin::Date-->
                            <span
                                class="fw-semibold text-muted text-end me-3">{{ \Carbon\Carbon::parse($hijo->fecha_creacion)->locale('es')->translatedFormat('d M, h:i a') }}</span>
                            @if (!empty($hijo->anexos))
                                @php
                                    $anexos = json_decode($hijo->anexos, true);
                                @endphp

                                <div class="separator separator-dashed my-7"></div>

                                <div class="card card-flush bg-light-primary">
                                    <div class="card-header pt-5 pb-3">
                                        <div class="card-title d-flex align-items-center">
                                            <i class="ki-duotone ki-folder-down fs-2 text-primary me-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <h6 class="fw-bold text-gray-800 mb-0">Archivos Adjuntos</h6>
                                            <span class="badge badge-light-primary ms-3">{{ count($anexos) }}</span>
                                        </div>
                                    </div>

                                    <div class="card-body pt-0 pb-5">
                                        <div class="row g-3">
                                            @foreach ($anexos as $index => $anexo)
                                                <div class="col-12">
                                                    <div
                                                        class="card card-flush border border-gray-300 hover-elevate-up">
                                                        <div class="card-body d-flex align-items-center py-4 px-5">
                                                            <!-- Icono del archivo -->
                                                            <div class="symbol symbol-45 me-4">
                                                                <div
                                                                    class="symbol-label bg-light-{{ $anexo['extension_tipo'] === 'pdf' ? 'danger' : ($anexo['extension_tipo'] === 'docx' || $anexo['extension_tipo'] === 'doc' ? 'primary' : ($anexo['extension_tipo'] === 'xlsx' || $anexo['extension_tipo'] === 'xls' ? 'success' : 'info')) }}">
                                                                    @if (in_array(strtolower($anexo['extension_tipo']), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                                        <i
                                                                            class="ki-duotone ki-picture fs-2 text-info">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                        </i>
                                                                    @elseif(strtolower($anexo['extension_tipo']) === 'pdf')
                                                                        <i
                                                                            class="ki-duotone ki-file-sheet fs-2 text-danger">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                        </i>
                                                                    @elseif(in_array(strtolower($anexo['extension_tipo']), ['doc', 'docx']))
                                                                        <i
                                                                            class="ki-duotone ki-document fs-2 text-primary">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                        </i>
                                                                    @elseif(in_array(strtolower($anexo['extension_tipo']), ['xls', 'xlsx']))
                                                                        <i
                                                                            class="ki-duotone ki-file-sheet fs-2 text-success">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                        </i>
                                                                    @elseif(in_array(strtolower($anexo['extension_tipo']), ['zip', 'rar', '7z']))
                                                                        <i
                                                                            class="ki-duotone ki-folder-down fs-2 text-warning">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                        </i>
                                                                    @else
                                                                        <i class="ki-duotone ki-file fs-2 text-info">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                        </i>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <!-- Información del archivo -->
                                                            <div class="flex-grow-1 me-3">
                                                                <div class="text-gray-800 fw-bold fs-6 mb-1">
                                                                    {{ $anexo['nombre_archivo'] }}
                                                                </div>
                                                                <div class="d-flex align-items-center">
                                                                    <span
                                                                        class="badge badge-light-{{ $anexo['extension_tipo'] === 'pdf' ? 'danger' : ($anexo['extension_tipo'] === 'docx' || $anexo['extension_tipo'] === 'doc' ? 'primary' : ($anexo['extension_tipo'] === 'xlsx' || $anexo['extension_tipo'] === 'xls' ? 'success' : 'info')) }} fs-7 fw-bold me-2">
                                                                        {{ strtoupper($anexo['extension_tipo']) }}
                                                                    </span>
                                                                    @if (isset($anexo['tamaño_archivo']))
                                                                        <span
                                                                            class="text-muted fs-7">{{ $anexo['tamaño_archivo'] }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <!-- Botones de acción -->
                                                            <div class="d-flex align-items-center">
                                                                @if (in_array(strtolower($anexo['extension_tipo']), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf']))
                                                                    <!-- Botón Ver en Modal (para imágenes y PDF) -->
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-icon btn-light-primary me-2"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#fileModal{{ $index }}"
                                                                        data-bs-toggle-tooltip="tooltip"
                                                                        title="Ver en modal">
                                                                        <i class="ki-duotone ki-eye fs-5">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                            <span class="path3"></span>
                                                                        </i>
                                                                    </button>
                                                                @endif

                                                                <!-- Botón Ver en nueva pestaña -->
                                                                <a href="{{ route('ver.archivoCasillaElectronica', $anexo['url_archivo']) }}"
                                                                    target="_blank"
                                                                    class="btn btn-sm btn-icon btn-light-info me-2"
                                                                    data-bs-toggle="tooltip"
                                                                    title="Abrir en nueva pestaña">
                                                                    <i class="ki-duotone ki-entrance-right fs-5">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                    </i>
                                                                </a>

                                                                <!-- Botón Descargar -->
                                                                <a href="{{ route('ver.archivoCasillaElectronica', $anexo['url_archivo']) }}"
                                                                    download
                                                                    class="btn btn-sm btn-icon btn-light-success"
                                                                    data-bs-toggle="tooltip" title="Descargar">
                                                                    <i class="ki-duotone ki-down fs-5">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                    </i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Modales para visualización de archivos -->
                                @foreach ($anexos as $index => $anexo)
                                    @if (in_array(strtolower($anexo['extension_tipo']), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf']))
                                        <div class="modal fade" id="fileModal{{ $index }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title d-flex align-items-center">
                                                            @if (in_array(strtolower($anexo['extension_tipo']), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                                <i class="ki-duotone ki-picture fs-2 text-info me-2">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>
                                                            @else
                                                                <i
                                                                    class="ki-duotone ki-file-sheet fs-2 text-danger me-2">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>
                                                            @endif
                                                            {{ $anexo['nombre_archivo'] }}
                                                        </h5>
                                                        <div class="btn-group">
                                                            <a href="{{ route('ver.archivoCasillaElectronica', $anexo['url_archivo']) }}"
                                                                target="_blank"
                                                                class="btn btn-sm btn-light-primary me-2"
                                                                data-bs-toggle="tooltip"
                                                                title="Abrir en nueva pestaña">
                                                                <i class="ki-duotone ki-entrance-right fs-5">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>
                                                                Abrir
                                                            </a>
                                                            <a href="{{ route('ver.archivoCasillaElectronica', $anexo['url_archivo']) }}"
                                                                download class="btn btn-sm btn-light-success me-2"
                                                                data-bs-toggle="tooltip" title="Descargar">
                                                                <i class="ki-duotone ki-down fs-5">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>
                                                                Descargar
                                                            </a>
                                                            <button type="button"
                                                                class="btn btn-sm btn-light-secondary"
                                                                data-bs-dismiss="modal">
                                                                <i class="ki-duotone ki-cross fs-5">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>
                                                                Cerrar
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="modal-body p-0">
                                                        @if (in_array(strtolower($anexo['extension_tipo']), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                            <!-- Vista previa de imagen -->
                                                            <div class="text-center bg-light p-5">
                                                                <img src="{{ route('ver.archivoCasillaElectronica', $anexo['url_archivo']) }}"
                                                                    alt="{{ $anexo['nombre_archivo'] }}"
                                                                    class="img-fluid rounded shadow-sm"
                                                                    style="max-height: 70vh; object-fit: contain;">
                                                            </div>
                                                        @elseif(strtolower($anexo['extension_tipo']) === 'pdf')
                                                            <!-- Vista previa de PDF -->
                                                            <embed
                                                                src="{{ route('ver.archivoCasillaElectronica', $anexo['url_archivo']) }}"
                                                                type="application/pdf" width="100%" height="600px"
                                                                class="rounded">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                            <!--end::Date-->
                            <div class="d-flex">
                                <!--begin::Star-->
                                {{-- <a href="#" class="btn btn-sm btn-icon btn-clear btn-active-light-primary me-3"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Star">
                                    <i class="ki-duotone ki-star fs-2 text m-0"></i>
                                </a> --}}
                                <a href="#"
                                        wire:click.prevent="marcarFavorito('{{ $hijo->nu_emi }}')"
                                        class="btn btn-sm btn-icon btn-clear btn-active-light-primary me-3"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Favorito">
                                            <i class="ki-duotone ki-star fs-2 m-0 {{ $hijo->flag_favorito == 1 ? 'text-warning' : '' }}">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </a>
                                <!--end::Star-->
                                <!--begin::Mark as important-->
                                {{-- <a href="#" class="btn btn-sm btn-icon btn-clear btn-active-light-primary me-3"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Mark as important">
                                    <i class="ki-duotone ki-save-2 fs-2 m-0">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </a>
                                <!--end::Mark as important-->
                                <!--begin::Reply-->
                                <a href="#" class="btn btn-sm btn-icon btn-clear btn-active-light-primary me-3"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Reply">
                                    <i class="ki-duotone ki-message-edit fs-2 m-0">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </a>
                                <!--end::Reply-->
                                <!--begin::Settings-->
                                <a href="#" class="btn btn-sm btn-icon btn-clear btn-active-light-primary"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Settings">
                                    <i class="ki-duotone ki-dots-square-vertical fs-2 m-0">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </a> --}}
                                <!--end::Settings-->
                            </div>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Message header-->
                    <!--begin::Message content-->
                    <div class="collapse fade" data-kt-inbox-message="message">
                        <div class="py-5">
                            <p>Hi Bob,</p>
                            <p>With resrpect, i must disagree with Mr.Zinsser. We all know the most part of important
                                part of
                                any
                                article is the title.Without a compelleing title, your reader won't even get to the
                                first
                                sentence.After the title, however, the first few sentences of your article are certainly
                                the
                                most
                                important part.</p>
                            <p>Jornalists call this critical, introductory section the "Lede," and when bridge properly
                                executed,
                                it's the that carries your reader from an headine try at attention-grabbing to the body
                                of your
                                blog
                                post, if you want to get it right on of these 10 clever ways to omen your next blog posr
                                with a
                                bang
                            </p>
                            <p>Best regards,</p>
                            <p class="mb-0">Jason Muller</p>
                        </div>
                    </div>
                    <!--end::Message content-->
                </div>
            @endforeach
        @else
            <p class="text-muted"></p>
        @endif
        {{-- <!--end::Message accordion-->
        <div class="separator my-6"></div>
        <!--begin::Message accordion-->
        <div data-kt-inbox-message="message_wrapper">
            <!--begin::Message header-->
            <div class="d-flex flex-wrap gap-2 flex-stack cursor-pointer" data-kt-inbox-message="header">
                <!--begin::Author-->
                <div class="d-flex align-items-center">
                    <!--begin::Avatar-->
                    <div class="symbol symbol-50 me-4">
                        <span class="symbol-label"
                            style="background-image:url(assets/media/avatars/300-5.jpg);"></span>
                    </div>
                    <!--end::Avatar-->
                    <div class="pe-5">
                        <!--begin::Author details-->
                        <div class="d-flex align-items-center flex-wrap gap-1">
                            <a href="#" class="fw-bold text-dark text-hover-primary">Sean Bean</a>
                            <i class="ki-duotone ki-abstract-8 fs-7 text-success mx-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <span class="text-muted fw-bold">3 days ago</span>
                        </div>
                        <!--end::Author details-->
                        <!--begin::Message details-->
                        <div class="d-none" data-kt-inbox-message="details">
                            <span class="text-muted fw-semibold">to me</span>
                            <!--begin::Menu toggle-->
                            <a href="#" class="me-1" data-kt-menu-trigger="click"
                                data-kt-menu-placement="bottom-start">
                                <i class="ki-duotone ki-down fs-5 m-0"></i>
                            </a>
                            <!--end::Menu toggle-->
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-300px p-4"
                                data-kt-menu="true">
                                <!--begin::Table-->
                                <table class="table mb-0">
                                    <tbody>
                                        <tr>
                                            <td class="w-75px text-muted">From</td>
                                            <td>Emma Bold</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Date</td>
                                            <td>20 Dec 2023, 6:05 pm</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Subject</td>
                                            <td>Trip Reminder. Thank you for flying with us!</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Reply-to</td>
                                            <td>emma@intenso.com</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!--end::Menu-->
                        </div>
                        <!--end::Message details-->
                        <!--begin::Preview message-->
                        <div class="text-muted fw-semibold mw-450px" data-kt-inbox-message="preview">Jornalists call
                            this
                            critical, introductory section the "Lede," and when bridge properly executed....</div>
                        <!--end::Preview message-->
                    </div>
                </div>
                <!--end::Author-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <!--begin::Date-->
                    <span class="fw-semibold text-muted text-end me-3">25 Oct 2023, 11:30 am</span>
                    <!--end::Date-->
                    <div class="d-flex">
                        <!--begin::Star-->
                        <a href="#" class="btn btn-sm btn-icon btn-clear btn-active-light-primary me-3"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Star">
                            <i class="ki-duotone ki-star fs-2 m-0"></i>
                        </a>
                        <!--end::Star-->
                        <!--begin::Mark as important-->
                        <a href="#" class="btn btn-sm btn-icon btn-clear btn-active-light-primary me-3"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Mark as important">
                            <i class="ki-duotone ki-save-2 fs-2 m-0">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </a>
                        <!--end::Mark as important-->
                        <!--begin::Reply-->
                        <a href="#" class="btn btn-sm btn-icon btn-clear btn-active-light-primary me-3"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Reply">
                            <i class="ki-duotone ki-message-edit fs-2 m-0">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </a>
                        <!--end::Reply-->
                        <!--begin::Settings-->
                        <a href="#" class="btn btn-sm btn-icon btn-clear btn-active-light-primary"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Settings">
                            <i class="ki-duotone ki-dots-square-vertical fs-2 m-0">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                            </i>
                        </a>
                        <!--end::Settings-->
                    </div>
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Message header-->
            <!--begin::Message content-->
            <div class="collapse fade" data-kt-inbox-message="message">
                <div class="py-5">
                    <p>Hi Bob,</p>
                    <p>With resrpect, i must disagree with Mr.Zinsser. We all know the most part of important part of
                        any
                        article is the title.Without a compelleing title, your reader won't even get to the first
                        sentence.After the title, however, the first few sentences of your article are certainly the
                        most
                        important part.</p>
                    <p>Jornalists call this critical, introductory section the "Lede," and when bridge properly
                        executed,
                        it's the that carries your reader from an headine try at attention-grabbing to the body of your
                        blog
                        post, if you want to get it right on of these 10 clever ways to omen your next blog posr with a
                        bang
                    </p>
                    <p>Best regards,</p>
                    <p class="mb-0">Jason Muller</p>
                </div>
            </div>
            <!--end::Message content-->
        </div>
        <!--end::Message accordion-->
        <!--begin::Form--> --}}


    @endif
    <!--end::Form-->
    </div>

        @if ($visible)
            <livewire:emitir-mensaje.emitir-mensaje-component :padre="$padre" :key="'emitir-mensaje-' . $padre->nu_emi" />
        @endif
</div>
    <script>
        // Inicializar tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        function printCardBody() {
            var printContents = document.getElementById("printable-area").innerHTML;
            var originalContents = document.body.innerHTML;

            // Reemplaza todo el contenido del body por solo el card-body
            document.body.innerHTML = printContents;

            window.print();

            // Luego de imprimir, vuelve a dejar el contenido original
            document.body.innerHTML = originalContents;
            location.reload(); // Recarga para evitar estado inconsistente
        }
    </script>
