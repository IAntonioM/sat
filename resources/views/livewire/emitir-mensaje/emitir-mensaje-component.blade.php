<div>
    <form id="kt_inbox_reply_form" class="rounded border mt-10" wire:submit.prevent="send">
        <!--begin::Body-->
        <div class="d-block">
            <!--begin::To-->
            <div class="d-flex align-items-center border-bottom px-8 min-h-50px">
                <!--begin::Label-->
                <div class="text-dark fw-bold w-75px">Para:</div>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control border-0" name="compose_to" wire:model="to" readonly />
                <!--end::Input-->
                <!--begin::CC & BCC buttons-->
                <div class="ms-auto w-75px text-end">
                    <span class="text-muted fs-bold cursor-pointer text-hover-primary me-2"
                        data-kt-inbox-form="cc_button">Cc</span>
                    <span class="text-muted fs-bold cursor-pointer text-hover-primary"
                        data-kt-inbox-form="bcc_button">Bcc</span>
                </div>
                <!--end::CC & BCC buttons-->
            </div>
            <!--end::To-->
            <!--begin::CC-->
            <div class="d-none align-items-center border-bottom ps-8 pe-5 min-h-50px" data-kt-inbox-form="cc">
                <!--begin::Label-->
                <div class="text-dark fw-bold w-75px">Cc:</div>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control border-0" wire:model="cc" />
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
            <div class="d-none align-items-center border-bottom inbox-to-bcc ps-8 pe-5 min-h-50px"
                data-kt-inbox-form="bcc">
                <!--begin::Label-->
                <div class="text-dark fw-bold w-75px">Bcc:</div>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control border-0" wire:model="bcc" />
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
                {{-- <input class="form-control border-0 px-8 min-h-45px"
                    wire:model="subject"
                    placeholder="Subject" /> --}}
            </div>
            <!--end::Subject-->
            <!--begin::Message-->
            <div class="px-8 py-3">
                <textarea wire:model="message" class="form-control border-0" rows="8" placeholder="Escribir mensaje..."
                    style="resize: vertical; min-height: 150px;"></textarea>
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
                                    <div
                                        class="d-flex align-items-center justify-content-between p-3 border border-gray-300 rounded dropzone-item ">
                                        <!--begin::Dropzone filename-->
                                        <div class="dropzone-file">
                                            <div class="dropzone-filename d-flex align-items-center">
                                                <i class="ki-duotone ki-file fs-3 text-primary me-3">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <div>
                                                    <span
                                                        class="fw-bold text-gray-800">{{ $attachment->getClientOriginalName() }}</span>
                                                    <div class="text-muted fs-7">
                                                        ({{ number_format($attachment->getSize() / 1024, 0) }} KB)</div>
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

            <!-- Loading indicator mientras se cargan los archivos -->
            <div wire:loading wire:target="newAttachments" class="text-center py-3 px-3">
                <div class="spinner-border spinner-border-sm text-primary" role="status">
                    <span class="visually-hidden">Cargando archivos...</span>
                </div>
                <span class="ms-2 text-muted">Cargando archivos...</span>
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
                    <button type="submit" class="btn btn-primary fs-bold px-6">
                        <span class="indicator-label">Enviar</span>
                        <span class="indicator-progress">Please wait...
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
                    id="kt_inbox_reply_attachments_select"
                    data-toggle="tooltip" title="Adjuntar Archivo"
                    onclick="document.getElementById('attachment-input').click()">
                    <i class="ki-duotone ki-paper-clip fs-2 m-0"></i>
                </span>
                <!--end::Upload attachement-->
                <!--begin::Pin-->
                {{-- <span class="btn btn-icon btn-sm btn-clean btn-active-light-primary">
                    <i class="ki-duotone ki-geolocation fs-2 m-0">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </span> --}}
                <!--end::Pin-->
            </div>
            <!--end::Actions-->
            <!--begin::Toolbar-->
            <div class="d-flex align-items-center">
                <!--begin::More actions-->
                {{-- <span class="btn btn-icon btn-sm btn-clean btn-active-light-primary me-2" data-toggle="tooltip"
                    title="Mas Acciones">
                    <i class="ki-duotone ki-setting-2 fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </span> --}}
                <!--end::More actions-->
                <!--begin::Dismiss reply-->
                <span
                    wire:click="limpiarMensaje"
                    class="btn btn-icon btn-sm btn-clean btn-active-light-primary"
                    data-inbox="dismiss"
                    data-toggle="tooltip"
                    title="Borrar Texto">
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
</div>
