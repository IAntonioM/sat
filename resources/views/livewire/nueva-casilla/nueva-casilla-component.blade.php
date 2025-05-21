
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
                <!--begin::Input-->
                <input type="text" class="form-control form-control-transparent border-0" name="compose_to"
                    wire:model.live.debounce.300ms="to" wire:keydown.enter="buscarUsuarios"
                    wire:keydown.arrow-down="$set('selectedIndex', {{ min(count($usuarios) - 1, $selectedIndex + 1) }})"
                    wire:keydown.arrow-up="$set('selectedIndex', {{ max(0, $selectedIndex - 1) }})"
                    wire:keydown.escape="cerrarListaUsuarios" placeholder="Buscar usuario..." autocomplete="off" />
                <!--end::Input-->

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
                                        {{-- <div class="badge badge-light-primary">{{ $usuario->vusuario }}</div> --}}
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
            </div>
            <!--end::Input Container-->

            <!--begin::CC & BCC buttons-->
            <div class="ms-auto w-75px text-end">
                <span class="text-muted fs-bold cursor-pointer text-hover-primary me-2"
                    data-kt-inbox-form="cc_button">Cc</span>
                <span class="text-muted fs-bold cursor-pointer text-hover-primary"
                    data-kt-inbox-form="bcc_button">Bcc</span>
            </div>
            <!--end::CC & BCC buttons-->
        </div>

        <!-- Overlay para cerrar la lista al hacer click fuera -->
        @if (!empty($usuarios) && $mostrarListaUsuarios)
            <div class="position-fixed w-100 h-100" style="top: 0; left: 0; z-index: 1040;"
                wire:click="cerrarListaUsuarios"></div>
        @endif
        <!--end::To-->
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
            <input class="form-control form-control-transparent border-0 px-8 min-h-45px" name="compose_subject"
                wire:model="subject" placeholder="Asunto" />
        </div>
        <!--end::Subject-->
        <!--begin::Message-->
        <div id="kt_inbox_form_editor" class="bg-transparent border-0 h-350px px-3">
            <textarea wire:model="message" class="form-control form-control-transparent border-0 h-100"
                placeholder="Escribir mensaje..." style="resize: none; height: 350px;"></textarea>
        </div>
        <!--end::Message-->
        <!--begin::Attachments-->
        <div class="dropzone dropzone-queue px-8 py-4" id="kt_inbox_reply_attachments" data-kt-inbox-form="dropzone">
            <div class="dropzone-items">
                <!-- File input hidden but triggered by button -->
                <input type="file" id="attachment-input" wire:model="attachments" multiple style="display: none;">

                <!-- Display attachments -->
                @if (count($attachments) > 0)
                    @foreach ($attachments as $index => $attachment)
                        <div class="dropzone-item">
                            <!--begin::Dropzone filename-->
                            <div class="dropzone-file">
                                <div class="dropzone-filename" title="{{ $attachment->getClientOriginalName() }}">
                                    <span data-dz-name="">{{ $attachment->getClientOriginalName() }}</span>
                                    <strong>(
                                        <span
                                            data-dz-size="">{{ number_format($attachment->getSize() / 1024, 0) }}kb</span>)</strong>
                                </div>
                                <div class="dropzone-error" data-dz-errormessage=""></div>
                            </div>
                            <!--end::Dropzone filename-->
                            <!--begin::Dropzone progress-->
                            <div class="dropzone-progress">
                                <div class="progress bg-gray-300">
                                    <div class="progress-bar bg-primary" role="progressbar" aria-valuemin="0"
                                        aria-valuemax="100" aria-valuenow="100" data-dz-uploadprogress=""></div>
                                </div>
                            </div>
                            <!--end::Dropzone progress-->
                            <!--begin::Dropzone toolbar-->
                            <div class="dropzone-toolbar">
                                <span class="dropzone-delete" wire:click="removeAttachment({{ $index }})">
                                    <i class="ki-duotone ki-cross fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                            </div>
                            <!--end::Dropzone toolbar-->
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <!--end::Attachments-->
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
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <!--end::Submit-->
                <!--begin::Send options-->
                <span class="btn btn-primary btn-icon fs-bold" role="button">
                    <span class="btn btn-icon" data-kt-menu-trigger="click" data-kt-menu-placement="top-start">
                        <i class="ki-duotone ki-down fs-2 m-0"></i>
                    </span>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-150px py-4"
                        data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">Schedule send</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">Save & archive</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">Cancel</a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu-->
                </span>
                <!--end::Send options-->
            </div>
            <!--end::Send-->
            <!--begin::Upload attachement-->
            <span class="btn btn-icon btn-sm btn-clean btn-active-light-primary me-2"
                id="kt_inbox_reply_attachments_select" data-kt-inbox-form="dropzone_upload"
                onclick="document.getElementById('attachment-input').click()">
                <i class="ki-duotone ki-paper-clip fs-2 m-0"></i>
            </span>
            <!--end::Upload attachement-->
            <!--begin::Pin-->
            <span class="btn btn-icon btn-sm btn-clean btn-active-light-primary">
                <i class="ki-duotone ki-geolocation fs-2 m-0">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </span>
            <!--end::Pin-->
        </div>
        <!--end::Actions-->
        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
            <!--begin::More actions-->
            <span class="btn btn-icon btn-sm btn-clean btn-active-light-primary me-2" data-toggle="tooltip"
                title="More actions">
                <i class="ki-duotone ki-setting-2 fs-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </span>
            <!--end::More actions-->
            <!--begin::Dismiss reply-->
            <span class="btn btn-icon btn-sm btn-clean btn-active-light-primary" data-inbox="dismiss"
                data-toggle="tooltip" title="Dismiss reply">
                <i class="ki-duotone ki-trash fs-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                    <span class="path5"></span>
                </i>
            </span>
            <!--end::Dismiss reply-->
        </div>
        <!--end::Toolbar-->
    </div>
    <!--end::Footer-->
</form>

<script>
    document.addEventListener('livewire:initialized', function() {
        // Show/hide CC field
        document.querySelector('[data-kt-inbox-form="cc_button"]').addEventListener('click', function() {
            document.querySelector('[data-kt-inbox-form="cc"]').classList.remove('d-none');
            document.querySelector('[data-kt-inbox-form="cc"]').classList.add('d-flex');
        });

        // Hide CC field
        document.querySelector('[data-kt-inbox-form="cc_close"]').addEventListener('click', function() {
            document.querySelector('[data-kt-inbox-form="cc"]').classList.remove('d-flex');
            document.querySelector('[data-kt-inbox-form="cc"]').classList.add('d-none');
        });

        // Show/hide BCC field
        document.querySelector('[data-kt-inbox-form="bcc_button"]').addEventListener('click', function() {
            document.querySelector('[data-kt-inbox-form="bcc"]').classList.remove('d-none');
            document.querySelector('[data-kt-inbox-form="bcc"]').classList.add('d-flex');
        });

        // Hide BCC field
        document.querySelector('[data-kt-inbox-form="bcc_close"]').addEventListener('click', function() {
            document.querySelector('[data-kt-inbox-form="bcc"]').classList.remove('d-flex');
            document.querySelector('[data-kt-inbox-form="bcc"]').classList.add('d-none');
        });
    });
</script>
