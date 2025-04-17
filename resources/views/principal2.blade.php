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
                
            </div>
            
            <!--end::Info-->
        </div>
        <!--end::Card body-->
        <!--begin::Card footer-->
        <div class="card-footer" style="border-top: 1px solid rgba(255, 255, 255, 0.3);background: rgba(0, 0, 0, 0.15);">
            <!--begin::Progress-->
            <div class="fw-bold text-white py-2" style="text-align: center;">
                <a href="#" class="btn btn-sm btn-light-danger btn-active-danger">
                    <i class="ki-duotone ki-plus fs-2"></i>Deudas Consolidadas</a>
                <span class="opacity-50"></span>
            </div>
            <!--end::Progress-->
        </div>
        <!--end::Card footer-->
    </div>
    <!--end::Card widget 3-->
</div>
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
                <span class="fs-2hx text-white fw-bold me-6" >Detallado</span>
                
            </div>
        </div>
        <!--end::Card body-->
        <!--begin::Card footer-->
        <div class="card-footer" style="border-top: 1px solid rgba(255, 255, 255, 0.3);background: rgba(0, 0, 0, 0.15);">
            <!--begin::Progress-->
            <div class="fw-bold text-white py-2" style="text-align: center;">
                <a href="#" class="btn btn-sm btn-light-info btn-active-info" >
                    <i class="ki-duotone ki-plus fs-2"></i>Deudas Detalladas</a>
                <span class="opacity-50"></span>
            </div>
            <!--end::Progress-->
        </div>
        <!--end::Card footer-->
    </div>
    <!--end::Card widget 3-->
</div>
<div class="col-xl-6">
    <!--begin::Tables Widget 9-->
    <div class="card ">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5 bg-light-warning  ">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1 text-warning ">Ultimos Pagos</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Realizados</span>
            </h3>
            <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" >
                <a href="#" class="btn btn-sm btn-light-warning  btn-active-warning ">
                <i class="ki-duotone ki-plus fs-2"></i>Ir a Mis Pagos</a>
            </div>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body py-3">
            <!--begin::Table container-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 table-bordered">
                    <!--begin::Table head-->
                    <thead>
                        <tr class="fw-bold text-warning " style="background-color:#f8f8f9;">
                            

                            <th style="width: 60%;text-align: center; " >Concepto</th>
                            <th style="width: 20%;text-align: center;">Fecha</th>
                            <th style="width: 20%;text-align: center;">Monto</th>
                            
                        </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                        <tr>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column ">
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
                            <td  style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="align-items-center">
                                    <div class="d-flex justify-content-start flex-column" style="text-align: center;">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7">S/.1350.00</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column ">
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
                            <td  style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="align-items-center">
                                    <div class="d-flex justify-content-start flex-column" style="text-align: center;">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7">S/.1350.00</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column ">
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
                            <td  style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="align-items-center">
                                    <div class="d-flex justify-content-start flex-column" style="text-align: center;">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7">S/.1350.00</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column ">
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
                            <td  style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="align-items-center">
                                    <div class="d-flex justify-content-start flex-column" style="text-align: center;">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7">S/.1350.00</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex justify-content-start flex-column ">
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
                            <td  style="padding-top: 13px;  padding-bottom: 13px;">
                                <div class="align-items-center">
                                    <div class="d-flex justify-content-start flex-column" style="text-align: center;">
                                        <span class="text-muted fw-semibold text-muted d-block fs-7">S/.1350.00</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Table container-->
        </div>
        <!--begin::Body-->
    </div>
    <!--end::Tables Widget 9-->
</div>
<div class="col-xl-6">
    <!--begin::Tiles Widget 4-->
    <div class="card h-150px card-xl-stretch bg-light-success ">
        <!--begin::Body-->
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
            <div class="me-2">
                <div class="text-muted fw-semibold fs-6  mb-3">Declaración Jurada</div>
                <h2 class="fw-bold  text-success">HR - Hoja de Resumen</h2>
                
            </div>
            <a href="#" class="btn btn-success fw-semibold"><i class="fa-solid fa-file"></i> Ir a HR</a>
        </div>
        <!--end::Body-->
    </div>
    <!--end::Tiles Widget 4-->
</div>
<div class="col-xl-6">
    <!--begin::Tiles Widget 4-->
    <div class="card h-150px card-xl-stretch bg-light-primary">
        <!--begin::Body-->
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
            <div class="me-2">
                
                <div class="text-muted fw-semibold fs-6 mb-3">Declaración Jurada</div>
                <h2 class="fw-bold text-primary">HLA - Hoja de Liquidación</h2>
            </div>
            <a href="#" class="btn btn-primary fw-semibold"><i class="fa-solid fa-file"></i> Ir a HLA</a>
        </div>
        <!--end::Body-->
    </div>
    <!--end::Tiles Widget 4-->
</div>

<div class="col-xl-6">
    <!--begin::Tables Widget 9-->
    <div class="card ">
        <!--begin::Header-->
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
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body py-3">
            <!--begin::Table container-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 table-bordered">
                    <!--begin::Table head-->
                    <thead>
                        <tr class="fw-bold text-muted" style="background-color:#f8f8f9;">
                            
                            <th style="width: 80%;text-align: center;">Concepto</th>
                            <th style="width: 20%;text-align: center;">Fecha</th>
                            
                            
                        </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
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
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Table container-->
        </div>
        <!--begin::Body-->
    </div>
    <!--end::Tables Widget 9-->
</div>
<div class="col-xl-6">
    <!--begin::Tables Widget 9-->
    <div class="card ">
        <!--begin::Header-->
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
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body py-3">
            <!--begin::Table container-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 table-bordered">
                    <!--begin::Table head-->
                    <thead>
                        <tr class="fw-bold text-muted" style="background-color:#f8f8f9;">
                            
                            <th style="width: 80%;text-align: center;">Concepto</th>
                            <th style="width: 20%;text-align: center;">Fecha</th>
                            
                        </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
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
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Table container-->
        </div>
        <!--begin::Body-->
    </div>
    <!--end::Tables Widget 9-->
</div>
<div class="col-xl-6">
    <!--begin::Tables Widget 9-->
    <div class="card ">
        <!--begin::Header-->
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
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body py-3">
            <!--begin::Table container-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 table-bordered">
                    <!--begin::Table head-->
                    <thead>
                        <tr class="fw-bold text-muted" style="background-color:#f8f8f9;">
                            
                            <th style="width: 80%;text-align: center;">Concepto</th>
                            <th style="width: 20%;text-align: center;">Fecha</th>
                            
                        </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
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
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Table container-->
        </div>
        <!--begin::Body-->
    </div>
    <!--end::Tables Widget 9-->
</div>
<div class="col-xl-6">
    <!--begin::Tables Widget 9-->
    <div class="card ">
        <!--begin::Header-->
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
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body py-3">
            <!--begin::Table container-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 table-bordered">
                    <!--begin::Table head-->
                    <thead>
                        <tr class="fw-bold text-muted" style="background-color:#f8f8f9;">
                            
                            <th style="width: 80%;text-align: center;">Concepto</th>
                            <th style="width: 20%;text-align: center;">Fecha</th>
                            
                            
                            
                        </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
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
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Table container-->
        </div>
        <!--begin::Body-->
    </div>
    <!--end::Tables Widget 9-->
</div>
@endsection