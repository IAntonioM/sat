@extends('layouts.cabeceraAdmin')
@section('content')
    <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
        <!--begin::Card header-->
        <div class="card-header cursor-pointer">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Perfil de Usurio</h3>
            </div>
            <!--end::Card title-->
            <!--begin::Action-->

            <!--end::Action-->
        </div>
        <!--begin::Card header-->
        <!--begin::Card body-->
        <div class="card-body p-9">
            <!--begin::Row-->
            <div class="row mb-7">
                <!--begin::Label-->
                <label class="col-lg-4 fw-semibold text-muted">Codigo de Contribuyente</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ $usuario->vcodcontr ?? '' }}</span>
                </div>
                <!--end::Col-->
            </div>
            <div class="separator separator-dashed my-6"></div>
            <div class="row mb-7">
                <!--begin::Label-->
                <label class="col-lg-4 fw-semibold text-muted">Apellidos y Nombres</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">
                        @if ($usuario->vdoc == 'RUC')
                            {{ $usuario->vrazon ?? '' }}
                        @else
                            {{ $usuario->vpater ?? '' }} {{ $usuario->vmater ?? '' }}
                            {{ $usuario->vnombre ?? '' }}
                        @endif
                    </span>
                </div>
                <!--end::Col-->
            </div>

            <div class="separator separator-dashed my-6"></div>
            <!--end::Row-->
            <!--begin::Input group-->
            <div class="row mb-7">
                <!--begin::Label-->
                <label class="col-lg-4 fw-semibold text-muted">Nro de Documento</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-lg-8 fv-row">
                    <span class="fw-semibold text-gray-800 fs-6">{{ $usuario->vnrodoc ?? '' }}</span>
                </div>
                <!--end::Col-->
            </div>
            <div class="separator separator-dashed my-6"></div>
            <div class="row mb-7">
                <!--begin::Label-->
                <label class="col-lg-4 fw-semibold text-muted">Dirección</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-lg-8 fv-row">
                    <span class="fw-semibold text-gray-800 fs-6">{{ $usuario->vdirec ?? '' }}</span>
                </div>
                <!--end::Col-->
            </div>
            <div class="separator separator-dashed my-6"></div>
            <div class="row mb-7">
                <!--begin::Label-->
                <label class="col-lg-4 fw-semibold text-muted">Centro Poblado</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-lg-8 fv-row">
                    <span class="fw-semibold text-gray-800 fs-6">{{ $usuario->vcentp ?? '' }}</span>
                </div>
                <!--end::Col-->
            </div>
            <div class="separator separator-dashed my-6"></div>

            <!-- Contacto en una sola línea -->
            <div class="row mb-7">
                <!--begin::Label-->
                <label class="col-lg-4 fw-semibold text-muted">Contacto</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-lg-8 fv-row">
                    <span class="fw-semibold text-gray-800 fs-6">
                        @if($usuario->vtel) <i class="fa-solid fa-phone me-1"></i>{{ $usuario->vtel }} @endif
                        @if($usuario->vcel) <i class="fa-solid fa-mobile-alt mx-1"></i>{{ $usuario->vcel }} @endif
                        @if($usuario->vcorreo) <i class="fa-solid fa-envelope mx-1"></i>{{ $usuario->vcorreo }} @endif
                        @if(!$usuario->vtel && !$usuario->vcel && !$usuario->vcorreo) Sin información de contacto @endif
                    </span>
                </div>
                <!--end::Col-->
            </div>
            <div class="separator separator-dashed my-6"></div>

        </div>
        <!--end::Card body-->
    </div>
@endsection
