<div class="d-none d-lg-flex flex-column flex-lg-row-auto w-100 w-lg-300px " data-kt-drawer="true"
    data-kt-drawer-name="inbox-aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
    data-kt-drawer-width="225px" data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_inbox_aside_toggle"style="background-color: #f9f9f9;">
    <!--begin::Sticky aside-->
    <div class="card card-flush mb-0" data-kt-sticky="false" data-kt-sticky-name="inbox-aside-sticky"
        data-kt-sticky-offset="{default: false, xl: '100px'}" data-kt-sticky-width="{lg: '275px'}"
        data-kt-sticky-left="auto" data-kt-sticky-top="100px" data-kt-sticky-animation="false"
        data-kt-sticky-zindex="95">
        <!--begin::Aside content-->
        <div class="card-body" style="background-color: #f9f9f9;">
            <!--begin::Button-->
            <a href="{{ route('createCasilla') }}" class="btn btn-primary fw-bold w-100 mb-8">Nuevo Mensaje</a>
            <!--end::Button-->
            <!--begin::Menu-->
            <div
                class="menu menu-column menu-rounded menu-state-bg menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary mb-10">
                <!-- Buzón de Notificaciones - tipo_id = 1 -->
                <div class="menu-item mb-3">
                    <span class="menu-link active">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-sms fs-2 me-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                        <span class="menu-title fw-bold">Buzón de Notificaciones</span>
                        <span class="badge badge-light-success">
                            {{ $conteoTipos[1] ?? 0 }}
                        </span>
                    </span>
                </div>

                <!-- Órdenes de Pago - tipo_id = 2 -->
                <div class="menu-item mb-3">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-abstract-23 fs-2 me-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                        <span class="menu-title fw-bold">Órdenes de Pago</span>
                        <span class="badge badge-light-primary">
                            {{ $conteoTipos[2] ?? 0 }}
                        </span>
                    </span>
                </div>

                <!-- Resoluciones de Determinación - tipo_id = 3 -->
                <div class="menu-item mb-3">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-file fs-2 me-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                        <span class="menu-title fw-bold">Resoluciones de Determinación</span>
                        <span class="badge badge-light-warning">
                            {{ $conteoTipos[3] ?? 0 }}
                        </span>
                    </span>
                </div>

                <!-- Documentos en Instancia Coactiva - tipo_id = 4 -->
                <div class="menu-item mb-3">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-send fs-2 me-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                        <span class="menu-title fw-bold">Documentos en Instancia Coactiva</span>
                        <span class="badge badge-light-danger">
                            {{ $conteoTipos[4] ?? 0 }}
                        </span>
                    </span>
                </div>
            </div>

            <!--end::Menu-->
            <!--begin::Menu-->

            <!--end::Menu-->
        </div>
        <!--end::Aside content-->
    </div>
    <!--end::Sticky aside-->
</div>
