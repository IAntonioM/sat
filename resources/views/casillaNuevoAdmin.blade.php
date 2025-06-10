@extends('layouts.cabeceraAdmin')
@section('content')
    <style>
        .table> :not(caption)>*>* {
            padding: 0.75rem 0.2rem;
        }
    </style>
    <div class="card " style="background-image: url(assets/media/logos/fondo1.jpg);background-position: center center;">
        <div class="card-body pt-9 pb-0">
            <!--begin::Details-->
            <div class="d-flex flex-wrap flex-sm-nowrap mb-6">

                <div class="flex-grow-1">
                    <!--begin::Head-->
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <!--begin::Details-->
                        <div class="d-flex flex-column">
                            <!--begin::Status-->
                            <div class="d-flex align-items-center mb-1">
                                <span class="text-gray-800 text-primary fs-1 fw-bold me-3">Casilla Electrónica</span>
                                <!--<span class="badge badge-light-success me-auto">In Progress</span>-->
                            </div>
                            <!--end::Status-->
                            <!--begin::Description-->
                            <div class="d-flex flex-wrap fw-semibold mb-4 fs-5 text-gray-400">
                                Actualizado al {{ \Carbon\Carbon::now()->format('d/m/Y') }}</div>
                            <!--end::Description-->
                        </div>

                    </div>
                    <!--end::Head-->

                </div>
            </div>
        </div>
    </div>
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start "
        style="padding-right: calc(0px * .5); padding-left: calc(0px * .5);">
        <!--begin::Post-->
        <div class="content flex-row-fluid" id="kt_content">
            <!--begin::Products-->
            <div class="card card-flush">
                <!--begin::Card header-->

                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <div class="d-flex flex-column flex-lg-row">

                        <livewire:menu-casilla-admin.menu-casilla-admin-component />
                        <div class="flex-lg-row-fluid ms-lg-7 ms-xl-10">
                            <!--begin::Card-->
                            <div class="card">
                                <div class="card-header d-flex align-items-center justify-content-between py-3">
                                    <h2 class="card-title m-0">Nuevo Mensaje</h2>
                                    <!--begin::Toggle-->
                                    <a href="#"
                                        class="btn btn-sm btn-icon btn-color-primary btn-light btn-active-light-primary d-lg-none"
                                        data-bs-toggle="tooltip" data-bs-dismiss="click" data-bs-placement="top"
                                        title="Toggle inbox menu" id="kt_inbox_aside_toggle">
                                        <i class="ki-duotone ki-burger-menu-2 fs-3 m-0">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                            <span class="path5"></span>
                                            <span class="path6"></span>
                                            <span class="path7"></span>
                                            <span class="path8"></span>
                                            <span class="path9"></span>
                                            <span class="path10"></span>
                                        </i>
                                    </a>
                                    <!--end::Toggle-->
                                </div>
                                <div class="card-body p-0">
                                    <!--begin::Form-->
                                    <livewire:nueva-casilla.nueva-casilla-component />

                                </div>
                            </div>
                            <!--end::Card-->
                        </div>
                    </div>



                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Products-->
        </div>
        <!--end::Post-->
    </div>
@endsection
