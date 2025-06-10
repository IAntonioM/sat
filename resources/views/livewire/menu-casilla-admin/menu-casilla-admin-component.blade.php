<div class="d-none d-lg-flex flex-column flex-lg-row-auto w-100 w-lg-300px" data-kt-drawer="true"
    data-kt-drawer-name="inbox-aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
    data-kt-drawer-width="225px" data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_inbox_aside_toggle" style="background-color: #f9f9f9;">

    <div class="card card-flush mb-0" data-kt-sticky="false" data-kt-sticky-name="inbox-aside-sticky"
        data-kt-sticky-offset="{default: false, xl: '100px'}" data-kt-sticky-width="{lg: '275px'}"
        data-kt-sticky-left="auto" data-kt-sticky-top="100px" data-kt-sticky-animation="false"
        data-kt-sticky-zindex="95">

        <div class="card-body" style="background-color: #f9f9f9;">
            <!-- Botón Nuevo Mensaje -->
            <a href="{{ route('createCasilla') }}" class="btn btn-primary fw-bold w-100 mb-8">Nuevo Mensaje</a>

            <!-- Menú de navegación -->
            <div class="menu menu-column menu-rounded menu-state-bg menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary mb-10">

                <!-- Buzón de Notificaciones - tipo_id = 1 -->
                <div class="menu-item mb-3">
                    <a href="{{ route('casilla', ['tipo' => 1]) }}"
                       class="menu-link {{ $tipoSeleccionado == 1 ? 'active' : '' }}"
                       wire:click="cambiarTipo(1)"
                       style="{{ $tipoSeleccionado == 1 ? 'background-color: #009ef7 !important; color: white !important;' : 'color: #181c32 !important;' }}">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-sms fs-2 me-3" style="{{ $tipoSeleccionado == 1 ? 'color: white !important;' : 'color: #5e6278 !important;' }}">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                        <span class="menu-title fw-bold" style="{{ $tipoSeleccionado == 1 ? 'color: white !important;' : 'color: #181c32 !important;' }}">Buzón de Notificaciones</span>
                        @if(isset($conteoTipos[1]) && $conteoTipos[1] > 0)
                            <span class="badge badge-light-success ms-auto {{ $tipoSeleccionado == 1 ? 'text-white' : '' }}"
                                  style="{{ $tipoSeleccionado == 1 ? 'background-color: rgba(255,255,255,0.2) !important; color: white !important;' : '' }}">{{ $conteoTipos[1] }}</span>
                        @endif
                    </a>
                </div>

                <!-- Órdenes de Pago - tipo_id = 2 -->
                <div class="menu-item mb-3">
                    <a href="{{ route('casilla', ['tipo' => 2]) }}"
                       class="menu-link {{ $tipoSeleccionado == 2 ? 'active' : '' }}"
                       wire:click="cambiarTipo(2)"
                       style="{{ $tipoSeleccionado == 2 ? 'background-color: #009ef7 !important; color: white !important;' : 'color: #181c32 !important;' }}">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-abstract-23 fs-2 me-3" style="{{ $tipoSeleccionado == 2 ? 'color: white !important;' : 'color: #5e6278 !important;' }}">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                        <span class="menu-title fw-bold" style="{{ $tipoSeleccionado == 2 ? 'color: white !important;' : 'color: #181c32 !important;' }}">Órdenes de Pago</span>
                        @if(isset($conteoTipos[2]) && $conteoTipos[2] > 0)
                            <span class="badge badge-light-primary ms-auto {{ $tipoSeleccionado == 2 ? 'text-white' : '' }}"
                                  style="{{ $tipoSeleccionado == 2 ? 'background-color: rgba(255,255,255,0.2) !important; color: white !important;' : '' }}">{{ $conteoTipos[2] }}</span>
                        @endif
                    </a>
                </div>

                <!-- Resoluciones de Determinación - tipo_id = 3 -->
                <div class="menu-item mb-3">
                    <a href="{{ route('casilla', ['tipo' => 3]) }}"
                       class="menu-link {{ $tipoSeleccionado == 3 ? 'active' : '' }}"
                       wire:click="cambiarTipo(3)"
                       style="{{ $tipoSeleccionado == 3 ? 'background-color: #009ef7 !important; color: white !important;' : 'color: #181c32 !important;' }}">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-file fs-2 me-3" style="{{ $tipoSeleccionado == 3 ? 'color: white !important;' : 'color: #5e6278 !important;' }}">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                        <span class="menu-title fw-bold" style="{{ $tipoSeleccionado == 3 ? 'color: white !important;' : 'color: #181c32 !important;' }}">Resoluciones de Determinación</span>
                        @if(isset($conteoTipos[3]) && $conteoTipos[3] > 0)
                            <span class="badge badge-light-warning ms-auto {{ $tipoSeleccionado == 3 ? 'text-white' : '' }}"
                                  style="{{ $tipoSeleccionado == 3 ? 'background-color: rgba(255,255,255,0.2) !important; color: white !important;' : '' }}">{{ $conteoTipos[3] }}</span>
                        @endif
                    </a>
                </div>

                <!-- Documentos en Instancia Coactiva - tipo_id = 4 -->
                <div class="menu-item mb-3">
                    <a href="{{ route('casilla', ['tipo' => 4]) }}"
                       class="menu-link {{ $tipoSeleccionado == 4 ? 'active' : '' }}"
                       wire:click="cambiarTipo(4)"
                       style="{{ $tipoSeleccionado == 4 ? 'background-color: #009ef7 !important; color: white !important;' : 'color: #181c32 !important;' }}">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-send fs-2 me-3" style="{{ $tipoSeleccionado == 4 ? 'color: white !important;' : 'color: #5e6278 !important;' }}">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                        <span class="menu-title fw-bold" style="{{ $tipoSeleccionado == 4 ? 'color: white !important;' : 'color: #181c32 !important;' }}">Documentos en Instancia Coactiva</span>
                        @if(isset($conteoTipos[4]) && $conteoTipos[4] > 0)
                            <span class="badge badge-light-danger ms-auto {{ $tipoSeleccionado == 4 ? 'text-white' : '' }}"
                                  style="{{ $tipoSeleccionado == 4 ? 'background-color: rgba(255,255,255,0.2) !important; color: white !important;' : '' }}">{{ $conteoTipos[4] }}</span>
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
