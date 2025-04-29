@extends('layouts.cabecera')
@section('content')
<div class="col-xl-3">
    <!--begin::Card widget 3-->
    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #F1416C;background-image:url('assets/media/svg/shapes/wave-bg-red.svg')">
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
                <span class="opacity-50">Pago en Linea</span>
                <span class="fs-2hx text-white fw-bold me-6" >Consolidado</span>
                <span class="opacity-50">Impuesto Predial y Arbitrios</span>
            </div>

            <!--end::Info-->
        </div>
        <!--end::Card body-->
        <!--begin::Card footer-->
        <div class="card-footer" style="border-top: 1px solid rgba(255, 255, 255, 0.3);background: rgba(0, 0, 0, 0.15);">
            <!--begin::Progress-->
            <div class="fw-bold text-white py-2" style="text-align: center;">
                <a href="{{ route('consolidado') }}" class="btn btn-sm btn-light-danger btn-active-danger">
                    <i class="ki-duotone ki-plus fs-2"></i>Deudas Consolidadas</a>
                <span class="opacity-50"></span>
            </div>
            <!--end::Progress-->
        </div>
        <!--end::Card footer-->
    </div>
    <!--end::Card widget 3-->
</div>
<div class="col-xl-1"></div>
<div class="col-xl-3">
    <!--begin::Card widget 3-->
    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #7239EA;background-image:url('assets/media/svg/shapes/wave-bg-purple.svg')">
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
                <span class="opacity-50">Pago en Linea</span>
                <span class="fs-2hx text-white fw-bold me-6" >Detallado</span><br>
                <span class="opacity-50">Impuesto Predial y Arbitrios</span>
            </div>
        </div>
        <!--end::Card body-->
        <!--begin::Card footer-->
        <div class="card-footer" style="border-top: 1px solid rgba(255, 255, 255, 0.3);background: rgba(0, 0, 0, 0.15);">
            <!--begin::Progress-->
            <div class="fw-bold text-white py-2" style="text-align: center;">
                <a href="{{ route('detallado') }}" class="btn btn-sm btn-light-info btn-active-info" >
                    <i class="ki-duotone ki-plus fs-2"></i>Deudas Detalladas</a>
                <span class="opacity-50"></span>
            </div>
            <!--end::Progress-->
        </div>
        <!--end::Card footer-->
    </div>
    <!--end::Card widget 3-->
</div>
<div class="col-xl-1"></div>
<div class="col-xl-3">
    <!--begin::Card widget 3-->
    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #0fb85b;background-image:url('assets/media/svg/shapes/widget-bg-3.png')">
        <!--begin::Header-->
        <div class="card-header pt-5 mb-3">
            <!--begin::Icon-->
            <div class="d-flex flex-center rounded-circle h-80px w-80px" style="border: 1px dashed rgba(255, 255, 255, 0.4);background-color: #0fb85b">

                <i class="fa-solid fa-file fs-1" style="color: #fff;"></i>
            </div>
            <!--end::Icon-->
        </div>
        <!--end::Header-->
        <!--begin::Card body-->
        <div class="card-body d-flex align-items-end mb-3">
            <div class="fw-bold text-white py-2">
                <span class="opacity-50">Declaración Jurada</span><br>
                <span class="fs-2hx text-white fw-bold me-6" >HR </span>

            </div>
        </div>
        <!--end::Card body-->
        <!--begin::Card footer-->
        <div class="card-footer" style="border-top: 1px solid rgba(255, 255, 255, 0.3);background: rgba(0, 0, 0, 0.15);">
            <!--begin::Progress-->
            <div class="fw-bold text-white py-2" style="text-align: center;">
                <a  href="{{ route('HR') }}" class="btn btn-sm btn-light-success btn-active-success " >
                    <i class="ki-duotone ki-plus fs-2"></i>Ir a la Hoja Resumen</a>
                <span class="opacity-50"></span>
            </div>
            <!--end::Progress-->
        </div>
        <!--end::Card footer-->
    </div>
    <!--end::Card widget 3-->
</div>
{{-- <div class="col-xl-3">
    <!--begin::Card widget 3-->
    <div class="card card-flush bgi-repeat bgi-size-contain bgi-position-x-end h-xl-100 " style="background-color: #009ef7;background-image:url('assets/media/svg/shapes/widget-bg-1.png'); ">
        <!--begin::Header-->
        <div class="card-header pt-5 mb-3">
            <!--begin::Icon-->
            <div class="d-flex flex-center rounded-circle h-80px w-80px" style="border: 1px dashed rgba(255, 255, 255, 0.4);background-color: #009ef7">
                <i class="fa-solid fa-file fs-1" style="color: #fff;"></i>
            </div>
            <!--end::Icon-->
        </div>
        <!--end::Header-->
        <!--begin::Card body-->
        <div class="card-body d-flex align-items-end mb-3">
            <div class="fw-bold text-white py-2">
                <span class="opacity-50">Declaración Jurada</span><br>
                <span class="fs-2hx text-white fw-bold me-6" >HLA </span>

            </div>
        </div>
        <!--end::Card body-->
        <!--begin::Card footer-->
        <div class="card-footer" style="border-top: 1px solid rgba(255, 255, 255, 0.3);background: rgba(0, 0, 0, 0.15);">
            <!--begin::Progress-->
            <div class="fw-bold text-white py-2" style="text-align: center;">
                <a href="#" class="btn btn-sm btn-light-primary btn-active-primary" >
                    <i class="ki-duotone ki-plus fs-2"></i>Ir a la Hoja de Liquidación</a>
                <span class="opacity-50"></span>
            </div>
            <!--end::Progress-->
        </div>
        <!--end::Card footer-->
    </div>
    <!--end::Card widget 3-->
</div> --}}
<div class="col-xl-2"></div>
<div class="col-xl-3">
    <!--begin::Card widget 3-->
    <div class="card card-flush bgi-repeat bgi-size-contain bgi-position-x-end h-xl-100 " style="background-color: #009ef7;background-image:url('assets/media/svg/shapes/widget-bg-1.png'); ">
        <!--begin::Header-->
        <div class="card-header pt-5 mb-3">
            <!--begin::Icon-->
            <div class="d-flex flex-center rounded-circle h-80px w-80px" style="border: 1px dashed rgba(255, 255, 255, 0.4);background-color: #009ef7">
                <i class="fa-solid fa-file fs-1" style="color: #fff;"></i>
            </div>
            <!--end::Icon-->
        </div>
        <!--end::Header-->
        <!--begin::Card body-->
        <div class="card-body d-flex align-items-end mb-3">
            <div class="fw-bold text-white py-2">
                <span class="opacity-50"></span><br>
                <span class="fs-2hx text-white fw-bold me-2" >Pago de </span>
                <span class="fs-2hx text-white fw-bold me-2" >Papeletas </span>
            </div>
        </div>
        <!--end::Card body-->
        <!--begin::Card footer-->
        <div class="card-footer" style="border-top: 1px solid rgba(255, 255, 255, 0.3);background: rgba(0, 0, 0, 0.15);">
            <!--begin::Progress-->
            <div class="fw-bold text-white py-2" style="text-align: center;">
                <a href="{{ route('pago_papeletas') }}" class="btn btn-sm btn-light-primary btn-active-primary" >
                    <i class="ki-duotone ki-plus fs-2"></i>Ir a Pago de Papeletas</a>
                <span class="opacity-50"></span>
            </div>
            <!--end::Progress-->
        </div>
        <!--end::Card footer-->
    </div>
    <!--end::Card widget 3-->
</div>
<div class="col-xl-1"></div>
<div class="col-xl-3">
    <!--begin::Card widget 3-->
    <div class="card card-flush bgi-repeat bgi-size-contain bgi-position-x-end h-xl-100 " style="background-color: #F6C000;background-image:url('assets/media/svg/shapes/widget-bg-4.png'); ">
        <!--begin::Header-->
        <div class="card-header pt-5 mb-3">
            <!--begin::Icon-->
            <div class="d-flex flex-center rounded-circle h-80px w-80px" style="border: 1px dashed rgba(255, 255, 255, 0.4);background-color: #F6C000">
                <i class="fa-solid fa-file fs-1" style="color: #fff;"></i>
            </div>
            <!--end::Icon-->
        </div>
        <!--end::Header-->
        <!--begin::Card body-->
        <div class="card-body d-flex align-items-end mb-3">
            <div class="fw-bold text-white py-2">
                <span class="opacity-50"></span><br>
                <span class="fs-2hx text-white fw-bold me-2" >Record </span>
                <span class="fs-2hx text-white fw-bold me-2" >Papeletas </span>


            </div>
        </div>
        <!--end::Card body-->
        <!--begin::Card footer-->
        <div class="card-footer" style="border-top: 1px solid rgba(255, 255, 255, 0.3);background: rgba(0, 0, 0, 0.15);">
            <!--begin::Progress-->
            <div class="fw-bold text-white py-2" style="text-align: center;">
                <a href="{{ route('record_papeleta') }}" class="btn btn-sm btn-light-warning btn-active-warning" >
                    <i class="ki-duotone ki-plus fs-2"></i>Ir a Record Papeletas</a>
                <span class="opacity-50"></span>
            </div>
            <!--end::Progress-->
        </div>
        <!--end::Card footer-->
    </div>
    <!--end::Card widget 3-->
</div>




<!--<div class="col-xl-6">
    <div class="card ">
        <div class="card-header border-0 pt-5 bg-light-info">
            <h3 class="card-title align-items-start flex-column ">
                <span class="card-label fw-bold fs-3 mb-1 text-info">Ultimas Notificaciones</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Casilla Electrónica</span>
            </h3>
            <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" >
                <a href="#" class="btn btn-sm btn-light-info btn-active-info" >
                <i class="ki-duotone ki-plus fs-2"></i>Ir a Buzón de Notificaciones</a>
            </div>
        </div>
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 table-bordered">
                    <thead>
                        <tr class="fw-bold text-muted" style="background-color:#f8f8f9;">
                            <th style="width: 80%;text-align: center;">Concepto</th>
                            <th style="width: 20%;text-align: center;">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7" style="padding-left: 10px; padding-right: 10px">Impuesto predial</span>
                                    </div>
                                </div>
                            </td>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="align-items-center">
                                    <div class="d-flex justify-content-start flex-column" style="text-align: center;">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7">12/04/2025</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7" style="padding-left: 10px; padding-right: 10px">Impuesto predial</span>
                                    </div>
                                </div>
                            </td>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="align-items-center">
                                    <div class="d-flex justify-content-start flex-column" style="text-align: center;">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7">12/04/2025</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7" style="padding-left: 10px; padding-right: 10px">Impuesto predial</span>
                                    </div>
                                </div>
                            </td>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="align-items-center">
                                    <div class="d-flex justify-content-start flex-column" style="text-align: center;">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7">12/04/2025</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7" style="padding-left: 10px; padding-right: 10px">Impuesto predial</span>
                                    </div>
                                </div>
                            </td>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="align-items-center">
                                    <div class="d-flex justify-content-start flex-column" style="text-align: center;">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7">12/04/2025</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7" style="padding-left: 10px; padding-right: 10px">Impuesto predial</span>
                                    </div>
                                </div>
                            </td>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="align-items-center">
                                    <div class="d-flex justify-content-start flex-column" style="text-align: center;">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7">12/04/2025</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="col-xl-6">
    <div class="card ">
        <div class="card-header border-0 pt-5 bg-light-danger">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1 text-danger">Ultimas Órdenes de Pago</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Casilla Electrónica</span>
            </h3>
            <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="Click to add a user">
                <a href="#" class="btn btn-sm btn-light-danger btn-active-danger" data-bs-toggle="modal" data-bs-target="#kt_modal_invite_friends">
                <i class="ki-duotone ki-plus fs-2"></i>Ir a Buzón de Ordenes de Pago</a>
            </div>
        </div>
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 table-bordered">
                    <thead>
                        <tr class="fw-bold text-muted" style="background-color:#f8f8f9;">
                            <th style="width: 80%;text-align: center;">Concepto</th>
                            <th style="width: 20%;text-align: center;">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7" style="padding-left: 10px; padding-right: 10px">Impuesto predial</span>
                                    </div>
                                </div>
                            </td>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="align-items-center">
                                    <div class="d-flex justify-content-start flex-column" style="text-align: center;">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7">12/04/2025</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7" style="padding-left: 10px; padding-right: 10px">Impuesto predial</span>
                                    </div>
                                </div>
                            </td>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="align-items-center">
                                    <div class="d-flex justify-content-start flex-column" style="text-align: center;">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7">12/04/2025</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7" style="padding-left: 10px; padding-right: 10px">Impuesto predial</span>
                                    </div>
                                </div>
                            </td>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="align-items-center">
                                    <div class="d-flex justify-content-start flex-column" style="text-align: center;">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7">12/04/2025</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7" style="padding-left: 10px; padding-right: 10px">Impuesto predial</span>
                                    </div>
                                </div>
                            </td>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="align-items-center">
                                    <div class="d-flex justify-content-start flex-column" style="text-align: center;">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7">12/04/2025</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7" style="padding-left: 10px; padding-right: 10px">Impuesto predial</span>
                                    </div>
                                </div>
                            </td>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="align-items-center">
                                    <div class="d-flex justify-content-start flex-column" style="text-align: center;">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7">12/04/2025</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="col-xl-6">
    <div class="card ">
        <div class="card-header border-0 pt-5 bg-light-warning">
            <h3 class="card-title align-items-start flex-column ">
                <span class="card-label fw-bold fs-4 mb-1 text-warning ">Ultimas Resoluciones de Determinación</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Casilla Electrónica</span>
            </h3>
            <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" >
                <a href="#" class="btn btn-sm btn-light-warning  btn-active-warning ">
                <i class="ki-duotone ki-plus fs-2"></i>Ir a Buzón de Resoluciones</a>
            </div>
        </div>
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 table-bordered">
                    <thead>
                        <tr class="fw-bold text-muted" style="background-color:#f8f8f9;">
                            <th style="width: 80%;text-align: center;">Concepto</th>
                            <th style="width: 20%;text-align: center;">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7" style="padding-left: 10px; padding-right: 10px">Impuesto predial</span>

                                    </div>
                                </div>
                            </td>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="align-items-center">
                                    <div class="d-flex justify-content-start flex-column" style="text-align: center;">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7">12/04/2025</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7" style="padding-left: 10px; padding-right: 10px">Impuesto predial</span>

                                    </div>
                                </div>
                            </td>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="align-items-center">
                                    <div class="d-flex justify-content-start flex-column" style="text-align: center;">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7">12/04/2025</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7" style="padding-left: 10px; padding-right: 10px">Impuesto predial</span>

                                    </div>
                                </div>
                            </td>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="align-items-center">
                                    <div class="d-flex justify-content-start flex-column" style="text-align: center;">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7">12/04/2025</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7" style="padding-left: 10px; padding-right: 10px">Impuesto predial</span>

                                    </div>
                                </div>
                            </td>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="align-items-center">
                                    <div class="d-flex justify-content-start flex-column" style="text-align: center;">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7">12/04/2025</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7" style="padding-left: 10px; padding-right: 10px">Impuesto predial</span>

                                    </div>
                                </div>
                            </td>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="align-items-center">
                                    <div class="d-flex justify-content-start flex-column" style="text-align: center;">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7">12/04/2025</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="col-xl-6">
    <div class="card ">
        <div class="card-header border-0 pt-5 bg-light-success">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-5 mb-1 text-success">Ultimos Documentos en Instancia Coactiva</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Casilla Electrónica</span>
            </h3>
            <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="Click to add a user">
                <a href="#" class="btn btn-sm btn-light-success btn-active-success" data-bs-toggle="modal" data-bs-target="#kt_modal_invite_friends">
                <i class="ki-duotone ki-plus fs-2"></i>Ir a Buzón de Documentos</a>
            </div>
        </div>
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 table-bordered">
                    <thead>
                        <tr class="fw-bold text-muted" style="background-color:#f8f8f9;">
                            <th style="width: 80%;text-align: center;">Concepto</th>
                            <th style="width: 20%;text-align: center;">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7" style="padding-left: 10px; padding-right: 10px">Impuesto predial</span>
                                    </div>
                                </div>
                            </td>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="align-items-center">
                                    <div class="d-flex justify-content-start flex-column" style="text-align: center;">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7">12/04/2025</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7" style="padding-left: 10px; padding-right: 10px">Impuesto predial</span>
                                    </div>
                                </div>
                            </td>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="align-items-center">
                                    <div class="d-flex justify-content-start flex-column" style="text-align: center;">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7">12/04/2025</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7" style="padding-left: 10px; padding-right: 10px">Impuesto predial</span>
                                    </div>
                                </div>
                            </td>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="align-items-center">
                                    <div class="d-flex justify-content-start flex-column" style="text-align: center;">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7">12/04/2025</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7" style="padding-left: 10px; padding-right: 10px">Impuesto predial</span>
                                    </div>
                                </div>
                            </td>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="align-items-center">
                                    <div class="d-flex justify-content-start flex-column" style="text-align: center;">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7">12/04/2025</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7" style="padding-left: 10px; padding-right: 10px">Impuesto predial</span>
                                    </div>
                                </div>
                            </td>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="align-items-center">
                                    <div class="d-flex justify-content-start flex-column" style="text-align: center;">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7">12/04/2025</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>-->
@endsection
