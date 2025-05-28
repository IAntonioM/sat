@extends('layouts.cabeceraAdmin')
@section('content')

@if($usuario->vestado == '002' )
<div class="col-xl-4">
    <!--begin::Card widget 3-->
    <div class="card card-flush bgi-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #F1416C;background-image:url('assets/media/svg/shapes/wave-bg-red.svg')">
        <!--begin::Header-->
        <div class="card-header pt-5 mb-3">
            <!--begin::Icon-->
            <div class="d-flex flex-center rounded-circle h-80px w-80px" style="border: 1px dashed rgba(255, 255, 255, 0.4);background-color: #F1416C">
                <i class="fa-solid fa-money-bill-1-wave fs-1" style="color: #fff;"></i>
            </div>
            <!--end::Icon-->
        </div>
        <!--end::Header-->
        <!--begin::Card body-->
        <div class="card-body d-flex align-items-end mb-3">
            <!--begin::Info-->
            <div class="fw-bold text-white py-2">

                <span class="fs-2hx text-white fw-bold me-6" >Mantenimiento de Usuarios</span>

            </div>

            <!--end::Info-->
        </div>
        <!--end::Card body-->
        <!--begin::Card footer-->
        <div class="card-footer" style="border-top: 1px solid rgba(255, 255, 255, 0.3);background: rgba(0, 0, 0, 0.15);">
            <!--begin::Progress-->
            <div class="fw-bold text-white py-2" style="text-align: center;">
                <a href="{{ route('UsuariosAdmin') }}" class="btn btn-sm btn-light-danger btn-active-danger">
                    <i class="ki-duotone ki-plus fs-2"></i>Ir a Mante. de Usuarios</a>
                <span class="opacity-50"></span>
            </div>
            <!--end::Progress-->
        </div>


        <!--end::Card footer-->
    </div>
    <!--end::Card widget 3-->
</div>
@endif

@if($usuario->vestado == '002' || $usuario->vestado == '003')
<div class="col-xl-4">
    <!--begin::Card widget 3-->
    <div class="card card-flush bgi-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #7239EA;background-image:url('assets/media/svg/shapes/wave-bg-purple.svg')">
        <!--begin::Header-->
        <div class="card-header pt-5 mb-3">
            <!--begin::Icon-->
            <div class="d-flex flex-center rounded-circle h-80px w-80px" style="border: 1px dashed rgba(255, 255, 255, 0.4);background-color: #7239EA">
                <i class="fa-solid fa-money-bill-1-wave fs-1" style="color: #fff;"></i>
            </div>
            <!--end::Icon-->
        </div>
        <!--end::Header-->
        <!--begin::Card body-->
        <div class="card-body d-flex align-items-end mb-3">
            <div class="fw-bold text-white py-2">

                <span class="fs-2hx text-white fw-bold me-6" >Pendientes por Aprobar</span><br>

            </div>
        </div>
        <!--end::Card body-->
        <!--begin::Card footer-->
        <div class="card-footer" style="border-top: 1px solid rgba(255, 255, 255, 0.3);background: rgba(0, 0, 0, 0.15);">
            <!--begin::Progress-->
            <div class="fw-bold text-white py-2" style="text-align: center;">
                <a href="{{ route('Pendiente') }}" class="btn btn-sm btn-light-info btn-active-info" >
                    <i class="ki-duotone ki-plus fs-2"></i>Ir a Pendientes por Aprobar</a>
                <span class="opacity-50"></span>
            </div>
            <!--end::Progress-->
        </div>
        <!--end::Card footer-->
    </div>
    <!--end::Card widget 3-->
</div>

@endif
<div class="col-xl-4">
    <!--begin::Card widget 3-->
    <div class="card card-flush bgi-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #2bcdff;background-image:url('assets/media/svg/shapes/widget-bg-5.png')">
        <!--begin::Header-->
        <div class="card-header pt-5 mb-3">
            <!--begin::Icon-->
            <div class="d-flex flex-center rounded-circle h-80px w-80px" style="border: 1px dashed rgba(255, 255, 255, 0.4);background-color: #2bcdff">
                <i class="fa-solid fa-money-bill-1-wave fs-1" style="color: #fff;"></i>
            </div>
            <!--end::Icon-->
        </div>
        <!--end::Header-->
        <!--begin::Card body-->
        <div class="card-body d-flex align-items-end mb-3">
            <!--begin::Info-->
            <div class="fw-bold text-white py-2">

                <span class="fs-2hx text-white fw-bold me-6" >Casilla Electronica</span>

            </div>

            <!--end::Info-->
        </div>
        <!--end::Card body-->
        <!--begin::Card footer-->
        <div class="card-footer" style="border-top: 1px solid rgba(241, 60, 60, 0.3);background: rgba(0, 0, 0, 0.15);">
            <!--begin::Progress-->
            <div class="fw-bold text-white py-2" style="text-align: center;">
                <a href="{{ route('casilla') }}" class="btn btn-sm btn-light-primary btn-active-primary">
                    <i class="ki-duotone ki-plus fs-2"></i>Ir a Casilla Electronica</a>
                <span class="opacity-50"></span>
            </div>
            <!--end::Progress-->
        </div>


        <!--end::Card footer-->
    </div>
    <!--end::Card widget 3-->
</div>
<livewire:chatbot.chatbot-component />


@endsection
