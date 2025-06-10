<form id="kt_inbox_compose_form" wire:submit.prevent="send">
    <!--begin::Body-->
    <div class="d-block">
        <!--begin::To-->
        <div class="d-flex align-items-center border-bottom px-8 min-h-50px position-relative">
            <!--begin::Label-->
            <div class="text-dark fw-bold w-75px">Para:</div>
            <!--end::Label-->

            <!--begin::Input Container-->
            <div class="flex-grow-1 position-relative">
                @if($esUsuarioNormal)
                    <!--begin::Campo fijo para usuario normal-->
                    <input type="text"
                           class="form-control form-control-transparent border-0"
                           value="ADMIN"
                           readonly
                           style="background-color: #f8f9fa; cursor: not-allowed;" />
                    <small class="text-muted">Como usuario contribuyente, sus mensajes se dirigen automáticamente al administrador.</small>
                    <!--end::Campo fijo para usuario normal-->
                @else
                    <!--begin::Input para usuarios admin-->
                    <input type="text" class="form-control form-control-transparent border-0" name="compose_to"
                        wire:model.live.debounce.300ms="to" wire:keydown.enter="buscarUsuarios"
                        wire:keydown.arrow-down="$set('selectedIndex', {{ min(count($usuarios) - 1, $selectedIndex + 1) }})"
                        wire:keydown.arrow-up="$set('selectedIndex', {{ max(0, $selectedIndex - 1) }})"
                        wire:keydown.escape="cerrarListaUsuarios" placeholder="Buscar usuario..." autocomplete="off" />

                    <!--begin::Dropdown Lista de Usuarios-->
                    @if (!empty($usuarios) && $mostrarListaUsuarios)
                        <div class="position-absolute w-100 bg-white border rounded shadow-sm"
                            style="top: 100%; z-index: 1050; max-height: 300px; overflow-y: auto;">
                            @foreach ($usuarios as $index => $usuario)
                                <div class="px-3 py-2 cursor-pointer border-bottom {{ $selectedIndex === $index ? 'bg-light' : '' }}"
                                    wire:click="seleccionarUsuario({{ $index }})"
                                    onmouseover="this.classList.add('bg-light')"
                                    onmouseout="this.classList.remove('bg-light')">

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-bold text-dark">
                                                {{ $usuario->vnombre }} {{ $usuario->vpater }} {{ $usuario->vmater }}
                                            </div>
                                            @if (!empty($usuario->vrazon))
                                                <div class="text-muted small">{{ $usuario->vrazon }}</div>
                                            @endif
                                            @if (!empty($usuario->vcorreo))
                                                <div class="text-primary small">{{ $usuario->vcorreo }}</div>
                                            @endif
                                        </div>
                                        <div class="text-end">
                                            <div class="badge badge-light-primary">Cod: {{ $usuario->vcodcontr ?? '' }}</div>
                                            @if (!empty($usuario->vnrodoc))
                                                <div class="text-muted small">Doc: {{ $usuario->vnrodoc }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            @if (count($usuarios) === 0 && !empty($to))
                                <div class="px-3 py-2 text-muted text-center">
                                    <i class="fas fa-search me-2"></i>No se encontraron usuarios
                                </div>
                            @endif
                        </div>
                    @endif
                    <!--end::Dropdown Lista de Usuarios-->
                    <!--end::Input para usuarios admin-->
                @endif
            </div>
            <!--end::Input Container-->
        </div>

        <!-- Overlay para cerrar la lista al hacer click fuera (solo para admins) -->
        @if (!$esUsuarioNormal && !empty($usuarios) && $mostrarListaUsuarios)
            <div class="position-fixed w-100 h-100" style="top: 0; left: 0; z-index: 1040;"
                wire:click="cerrarListaUsuarios"></div>
        @endif
        <!--end::To-->

        <!--begin::Area/Tipo Documento-->
        <div class="d-flex align-items-center border-bottom px-8 min-h-50px">
            <!--begin::Label-->
            <div class="text-dark fw-bold w-75px">Área:</div>
            <!--end::Label-->
            <!--begin::Select-->
            <div class="flex-grow-1">
                <select class="form-select form-select-transparent border-0"
                        wire:model="tipoDocumentoEmitidoId"
                        name="tipo_documento_emitido_id">
                    <option value="">Seleccionar área de destino...</option>
                    @foreach ($tiposDocumento as $tipoDoc)
                        <option value="{{ $tipoDoc->id }}">{{ $tipoDoc->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <!--end::Select-->
        </div>
        <!--end::Area/Tipo Documento-->

        <!--begin::CC-->
        <div class="d-none align-items-center border-bottom ps-8 pe-5 min-h-50px" data-kt-inbox-form="cc">
            <!--begin::Label-->
            <div class="text-dark fw-bold w-75px">Cc:</div>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" class="form-control form-control-transparent border-0" name="compose_cc"
                wire:model="cc" data-kt-inbox-form="tagify" />
            <!--end::Input-->
            <!--begin::Close-->
            <span class="btn btn-clean btn-xs btn-icon" data-kt-inbox-form="cc_close">
                <i class="ki-duotone ki-cross fs-5">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </span>
            <!--end::Close-->
        </div>
        <!--end::CC-->

        <!--begin::BCC-->
        <div class="d-none align-items-center border-bottom inbox-to-bcc ps-8 pe-5 min-h-50px" data-kt-inbox-form="bcc">
            <!--begin::Label-->
            <div class="text-dark fw-bold w-75px">Bcc:</div>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" class="form-control form-control-transparent border-0" name="compose_bcc"
                wire:model="bcc" data-kt-inbox-form="tagify" />
            <!--end::Input-->
            <!--begin::Close-->
            <span class="btn btn-clean btn-xs btn-icon" data-kt-inbox-form="bcc_close">
                <i class="ki-duotone ki-cross fs-5">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </span>
            <!--end::Close-->
        </div>
        <!--end::BCC-->

        <!--begin::Subject-->
        <div class="border-bottom">
            <input class="form-control form-control-transparent border-0 px-8 min-h-45px"
                   name="compose_subject"
                   wire:model="subject"
                   placeholder="Asunto" />
        </div>
        <!--end::Subject-->

        <!--begin::Message-->
        <div id="kt_inbox_form_editor" class="bg-transparent border-0 h-350px px-3">
            <textarea wire:model="message"
                      class="form-control form-control-transparent border-0 h-100"
                      placeholder="Escribir mensaje..."
                      style="resize: none; height: 350px;"></textarea>
        </div>
        <!--end::Message-->

        <!--begin::Attachments-->
        <div class="dropzone dropzone-queue px-8 py-4" id="kt_inbox_reply_attachments">
            <div class="dropzone-items">
                <!-- File input que permite múltiples archivos -->
                <input type="file" id="attachment-input" wire:model="newAttachments" multiple
                    style="display: none;">

                <!-- Display attachments -->
                @if (count($attachments) > 0)
                    <div class="mt-4">
                        <div class="separator separator-dashed mb-4"></div>
                        <div class="fw-bold mb-3">Archivos adjuntos ({{ count($attachments) }}):</div>

                        @foreach ($attachments as $index => $attachment)
                            <div class="mb-2">
                                <div class="d-flex align-items-center justify-content-between p-3 border border-gray-300 rounded dropzone-item">
                                    <!--begin::Dropzone filename-->
                                    <div class="dropzone-file">
                                        <div class="dropzone-filename d-flex align-items-center">
                                            <i class="ki-duotone ki-file fs-3 text-primary me-3">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <div>
                                                <span class="fw-bold text-gray-800">{{ $attachment->getClientOriginalName() }}</span>
                                                <div class="text-muted fs-7">
                                                    ({{ number_format($attachment->getSize() / 1024, 0) }} KB)
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Dropzone filename-->

                                    <!--begin::Dropzone toolbar-->
                                    <div class="dropzone-toolbar d-flex gap-2">
                                        <!-- Botón para ver archivo -->
                                        <a href="{{ route('ver.archivoCasilla', $attachment->getFilename()) }}"
                                            target="_blank" class="btn btn-sm btn-icon btn-light-success"
                                            title="Ver archivo">
                                            <i class="ki-duotone ki-eye fs-6">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                        </a>

                                        <!-- Botón para eliminar archivo -->
                                        <button type="button" class="btn btn-sm btn-icon btn-light-danger"
                                            wire:click="removeAttachment({{ $index }})"
                                            title="Eliminar archivo">
                                            <i class="ki-duotone ki-cross fs-6">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </button>
                                    </div>
                                    <!--end::Dropzone toolbar-->
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        <!--end::Attachments-->

        <!--begin::Error Messages-->
        @if ($errors->any())
            <div class="alert alert-danger mx-8 mb-0">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!--end::Error Messages-->

        <!--begin::Success/Error Messages-->
        @if (session()->has('message'))
            <div class="alert alert-success mx-8 mb-0">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger mx-8 mb-0">
                {{ session('error') }}
            </div>
        @endif
        <!--end::Success/Error Messages-->
    </div>
    <!--end::Body-->

    <!--begin::Footer-->
    <div class="d-flex flex-stack flex-wrap gap-2 py-5 ps-8 pe-5 border-top">
        <!--begin::Actions-->
        <div class="d-flex align-items-center me-3">
            <!--begin::Send-->
            <div class="btn-group me-4">
                <!--begin::Submit-->
                <button type="submit" class="btn btn-primary fs-bold px-6" data-kt-inbox-form="send">
                    <span class="indicator-label">Enviar</span>
                    <span class="indicator-progress">Espere por favor...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
                <!--end::Submit-->
            </div>
            <!--end::Send-->

            <!--begin::Upload attachement-->
            <span class="btn btn-icon btn-sm btn-clean btn-active-light-primary me-2"
                id="kt_inbox_reply_attachments_select" data-kt-inbox-form="dropzone_upload"
                onclick="document.getElementById('attachment-input').click()">
                <i class="ki-duotone ki-paper-clip fs-2 m-0"></i>
            </span>
            <!--end::Upload attachement-->

            <!--begin::Clear form-->
            <button type="button" class="btn btn-icon btn-sm btn-clean btn-active-light-secondary me-2"
                wire:click="limpiarFormulario" title="Limpiar formulario">
                <i class="ki-duotone ki-trash fs-2 m-0"></i>
            </button>
            <!--end::Clear form-->
        </div>
        <!--end::Actions-->
    </div>
    <!--end::Footer-->
</form>
