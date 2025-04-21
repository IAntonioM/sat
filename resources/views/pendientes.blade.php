@extends('layouts.cabeceraAdmin')
@section('content')

<div class="card " style="background-image: url(assets/media/logos/fondo1.jpg);background-position: center center;">
    <div class="card-body pt-9 pb-0">
        <!--begin::Details-->
        <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
            <!--begin::Image-->
            <!--<div class="d-flex flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
                <img class="mw-50px mw-lg-75px" src="assets/media/svg/brand-logos/volicity-9.svg" alt="image" />
            </div>-->
            <!--end::Image-->
            <!--begin::Wrapper-->
            <div class="flex-grow-1">
                <!--begin::Head-->
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <!--begin::Details-->
                    <div class="d-flex flex-column">
                        <!--begin::Status-->
                        <div class="d-flex align-items-center mb-1">
                            <span class="text-gray-800 text-primary fs-1 fw-bold me-3">Pendientes por Aprobar</span>
                            <!--<span class="badge badge-light-success me-auto">In Progress</span>-->
                        </div>
                        <!--end::Status-->
                        <!--begin::Description-->
                        <div class="d-flex flex-wrap fw-semibold mb-4 fs-5 text-gray-400">Actualizados al    15/04/2025</div>
                        <!--end::Description-->
                    </div>
                    <!--
                    <div class="d-flex mb-4">
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3 badge-light-primary">
                            <div class="fw-semibold fs-6 text-gray-400">Su Deuda Actual es:</div>
                            <div class="d-flex align-items-center">
                                <div class=" fw-bold" data-kt-countup="true" data-kt-countup-value="15000" data-kt-countup-prefix="S/." style="font-size:30px">0</div>
                            </div>
                        </div>  
                    </div>
                    -->
                </div>
                <!--end::Head-->
                
            </div>
        </div>
    </div>
</div>

<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start " style="padding-right: calc(0px * .5); padding-left: calc(0px * .5);">
    <!--begin::Post-->
    <div class="content flex-row-fluid" id="kt_content">
        <!--begin::Products-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="w-200 mw-250px" style="padding-right: 10px;" >
                        <!--begin::Select2-->
                        <select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Seleccione el Estado" data-kt-ecommerce-order-filter="Seleccione el Año">
                            <option></option>
                            <option value="all">Todos</option>
                            <option value="2025">Activo</option>
                            <option value="2025">Desactivado</option>
                            
                        </select> 
                        <!--end::Select2-->
                    </div>
                    <div class="w-300 mw-350px">
                        <!--begin::Select2-->
                        <input type="text" placeholder="Buscar..."  autocomplete="off" class="form-control bg-transparent" />
                        <!--end::Select2-->
                    </div>
                    <!--end::Search-->
                </div>
                <!--end::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                    
                    
                    <!--begin::Add product-->
                    <a href="" class="btn btn-primary"><i class="fa-solid fa-print"></i>Imprimir</a>
                    
                    
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5 table-bordered" id="kt_ecommerce_sales_table">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0" style="background-color:#f8f8f9;">
                            
                            <th class="min-w-175px" style="text-align: center;">Nombre/Razón Social</th>
                            <th class="min-w-30px" style="text-align: center;">Asunto</th>
                            <th class=" min-w-30px" style="text-align: center;">Fecha de Registro</th>
                            <th class=" min-w-30px" style="text-align: center;">Fecha de Actualización</th>
                            <th class=" min-w-30px" style="text-align: center;">Usuario</th>
                            <th class=" min-w-30px" style="text-align: center;">Estado</th>
                            <th class=" min-w-100px" style="text-align: center;"></th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                       
                        <tr style="text-align: center; font-size:12px">
                            <td>sss</td>
                            <td>2024-1</td>
                            <td>450.00</td>
                            <td>0.00</td>
                            <td>sss</td>
                            <td><div class="badge badge-light-success" style="font-size:12px">Activo</div></td>
                            <td>
                                <a href="#" class="btn  btn-active-color-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user" style="padding: 0rem;">
                                    <i class="fa-solid fa-pen-to-square fs-2"></i>
                                </a>
                                <a href="#" class="btn btn-active-color-danger btn-sm me-1" style="padding: 0rem;">
                                <i class="fa-solid fa-trash fs-2"></i>
                                </a>
                            </td>
                            
                        </tr>
                        <tr style="text-align: center; font-size:12px">
                            <td>dd</td>
                            <td>2024-2</td>
                            <td>450.00</td>
                            <td>0.00</td>
                            <td>sss</td>
                            <td><div class="badge badge-light-danger" style="font-size:12px">Desactivado</div></td>
                            <td>
                                <a href="#" class="btn  btn-active-color-primary btn-sm me-1" style="padding: 0rem;">
                                    <i class="fa-solid fa-pen-to-square fs-2"></i>
                                </a>
                                <a href="#" class="btn btn-active-color-danger btn-sm me-1" style="padding: 0rem;">
                                <i class="fa-solid fa-trash fs-2"></i>
                                </a>
                            </td>
                            
                        </tr>
                        

                       
                       
                    </tbody>
                </table>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Products-->
    </div>
    <!--end::Post-->
</div>
<div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_user_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Actualizar</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body px-5 my-7">
                <!--begin::Form-->
                <form id="kt_modal_add_user_form" class="form" action="#">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                        
                        <!--begin::Input group-->
                        <div class="col-xl-12 row pb-5 " >
                            <div class="col-xl-12 "  style="padding: 0px 5px 0px 0px">
                            <label class="required fw-semibold fs-6 mb-2">Nombre/Razón Social</label>
                           
                            <input type="text" name="apellidos" class="form-control form-control-solid mb-3 mb-lg-0"   />
                            </div>
                            
                            <!--end::Input-->
                        </div>

                        <div class="col-xl-12 row pb-5 " >
                            <div class="col-xl-6 "  style="padding: 0px 5px 0px 0px">
                            <label class="required fw-semibold fs-6 mb-2">Fecha de Registro</label>
                           
                            <input type="date" name="fecha1" class="form-control form-control-solid mb-3 mb-lg-0"   />
                            </div>
                            <div class="col-xl-6 "  style="padding: 0px 0px 0px 5px">
                                <label class="required fw-semibold fs-6 mb-2">Fecha de Actualización</label>
                               
                                <input type="date" name="fecha2" class="form-control form-control-solid mb-3 mb-lg-0"   />
                                </div>
                            <!--end::Input-->
                        </div>
                        <div class="col-xl-12 row pb-5 " >
                            <div class="col-xl-6 "  style="padding: 0px 5px 0px 0px">
                            <label class="required fw-semibold fs-6 mb-2">Usuario</label>
                           
                            <input type="text" name="fecha" class="form-control form-control-solid mb-3 mb-lg-0"   />
                            </div>
                            <div class="col-xl-6 "  style="padding: 0px 0px 0px 5px">
                                <label class="required fw-semibold fs-6 mb-2">Estado</label>
                               
                                <select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Seleccione el Estado" data-kt-ecommerce-order-filter="Seleccione el Año">
                                    <option></option>
                                    <option value="all">Todos</option>
                                    <option value="2025">Activo</option>
                                    <option value="2025">Desactivado</option>
                                    
                                </select>
                                </div>
                            <!--end::Input-->
                        </div>

                        <div class="col-xl-12 row pb-5 " >
                            <div class="col-xl-12 "  style="padding: 0px 5px 0px 0px">
                            <label class="required fw-semibold fs-6 mb-2">Asunto</label>
                           
                            <textarea class="form-control bg-transparent" name="asunto" placeholder="Asunto/Sumilla"></textarea>
                            </div>
                            
                            <!--end::Input-->
                        </div>



                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-10">
                        <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Cancelar</button>
                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                            <span class="indicator-label">Guardar</span>
                            <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>

@endsection