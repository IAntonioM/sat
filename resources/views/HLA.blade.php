@extends('layouts.cabecera')
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
                            <span class="text-gray-800 text-primary fs-1 fw-bold me-3">Hoja de Liquidación (HLA)</span>
                            <!--<span class="badge badge-light-success me-auto">In Progress</span>-->
                        </div>
                        <!--end::Status-->
                        <!--begin::Description-->
                        <div class="d-flex flex-wrap fw-semibold mb-4 fs-5 text-gray-400">Deudas del Contribuyente al    15/04/2025</div>
                        <!--end::Description-->
                    </div>
                    <!--end::Details-->
                    <!--begin::Actions-->
                    <div class="d-flex mb-4">
                        <a href="" class="btn btn-primary"><i class="fa-solid fa-print"></i>Imprimir</a>
                    </div>
                    <!--end::Actions-->
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
            <div class="card-header align-items-center py-5 gap-2 gap-md-5" style="flex-wrap: initial">
                <div class="col-xl-3"><img src="assets/media/logos/custom-3-h25-2.png" alt=""></div>
                <div class="col-xl-6" style="text-align: center"><span class="fs-1">DETERMINACIÓN DE ARBITRIOS 2025</span><br>
                    <!--<span class="fs-8">DECLARACIÓN JURADA</span><br>
                        <span class="fs-8">T.U.O. DE LA LEY DE TRIBUTACIÓN MUNICIPAL (D.S.N° 156-2004-EF)</span>--></div>
                <div class="col-xl-3" style="text-align: center"><span class="fs-1">HLA</span><br><span>(Hoja de Liquidación)</span></div>
            
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0" >
                <div class="col-xl-12" style="border: 0px solid var(--bs-gray-300); padding:10px;">
                    I. DATOS DEL CONTRIBUYENTE 
                </div>
                <div class="col-xl-12 row" style="border: 1px solid var(--bs-gray-300);margin-left: 0;margin-right:0;--bs-gutter-x: 0rem;">
                    
                    <div class="col-xl-10 row" style="margin-left: 0;margin-right:0;--bs-gutter-x: 0rem;"> 
                        <div class="col-xl-4" style="font-size:10px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center ">
                            CONTRIBUYENTE:
                        </div>
                        <div class="col-xl-8" style="font-size:10px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;">
                        j
                        </div>

                        <div class="col-xl-4" style="font-size:10px;border-right: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center ">
                            DOMICILIO FISCAL:
                        </div>
                        <div class="col-xl-8" style="font-size:10px;border-right: 1px solid var(--bs-gray-300); padding:10px;">
                        t
                        </div>
                    </div>
                    <div class="col-xl-2 row" style="margin-left: 0;margin-right:0;--bs-gutter-x: 0rem;">



                        <div class="col-xl-12 row" >
                        
                            <div class="col-xl-12 " style="font-size:10px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:12px;background-color:#f8f8f9;text-align: center ">
                                CODIGO DE CONTRIBUYENTE
                            </div>
                            
                            <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            0000004
                            </div>
                        
                    </div>
                   




                        
                    </div>
                </div>
                <div class="col-xl-12" style="border: 0px solid var(--bs-gray-300); padding:10px;">
                    II. DETERMINACION (S/.)
                </div>
                <div class="col-xl-12 row" style="border: 1px solid var(--bs-gray-300);margin-left: 0;margin-right:0;--bs-gutter-x: 0rem;">
                    <div class="col-xl-1 row" >
                        
                            <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center ">
                                CODIGO PREDIO
                            </div>
                            
                            <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            0000004
                            </div>
                        
                    </div>
                    <div class="col-xl-2 row" >
                        
                            <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center ">
                                UBICACION DEL PREDIO
                            </div>
                            
                            <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            0000004
                            </div>
                        
                    </div>
                    <div class="col-xl-1 row" >
                        
                            <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center ">
                                FRONTIS
                            </div>
                            
                            <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            0000004
                            </div>
                        
                    </div>
                    <div class="col-xl-1 row" >
                        
                        <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center ">
                            ZONA
                        </div>
                        
                        <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                        0000004
                        </div>
                    
                    </div>
                    <div class="col-xl-1 row" >
                        
                            <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center ">
                                USO
                            </div>
                            
                            <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            0000004
                            </div>
                       
                    </div>
                    <div class="col-xl-1 row" >
                        
                            <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px 0px 10px 0px;background-color:#f8f8f9;text-align: center ">
                                % PROP
                            </div>
                            
                            <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            0000004
                            </div>
                        
                    </div>
                    <div class="col-xl-1 row" >
                        
                        <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px 0px 10px 0px;background-color:#f8f8f9;text-align: center ">
                            RESIDUOS SOLIDOS	
                        </div>
                        
                        <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                        0000004
                        </div>
                    
                    </div>
                    <div class="col-xl-1 row" >
                        
                        <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px 0px 10px 0px;background-color:#f8f8f9;text-align: center ">
                            BARRIDO DE CALLES
                        </div>
                        
                        <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                        0000004
                        </div>
                    
                    </div>
                    <div class="col-xl-1 row" >
                        
                            <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px 0px 10px 0px;background-color:#f8f8f9;text-align: center ">
                                PARQUES Y JARDINES
                            </div>
                            
                            <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            0000004
                            </div>
                    
                    </div>
                    <div class="col-xl-1 row" >
                        
                            <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px 0px 10px 0px;background-color:#f8f8f9;text-align: center ">
                                SERENAZGO
                            </div>
                            
                            <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            0000004
                            </div>
                        
                    </div>
                    <div class="col-xl-1 row" >
                        
                            <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center ">
                                TOTAL
                            </div>
                            
                            <div class="col-xl-12" style="border-right: 0px solid var(--bs-gray-300); padding:10px;text-align: center">
                            0000004
                            </div>
                        
                    </div>
                </div>
                
                <div class="col-xl-12 row" style="border: 1px solid var(--bs-gray-300);margin-left: 0;margin-right:0;--bs-gutter-x: 0rem;">
                    <div class="col-xl-7 row" >
                        
                            <div class="col-xl-12 " style="font-size:10px;border-right: 1px solid var(--bs-gray-300);border-bottom: 0px solid var(--bs-gray-300);border-top: 0px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: right ">
                                SUB TOTAL:
                            </div>
                            
                          
                    </div>
                    <div class="col-xl-1 row" >
                        
                            <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            0000004
                            </div>
                        
                    </div>
                    <div class="col-xl-1 row" >
                        
                            
                            
                            <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            0000004
                            </div>
                        
                    </div>
                    <div class="col-xl-1 row" >
                        
                          
                            
                            <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            0000004
                            </div>
                       
                    </div>
                    <div class="col-xl-1 row" >
                        
                            
                            <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            0000004
                            </div>
                        
                    </div>
                    <div class="col-xl-1 row" >
                       
                         
                            
                            <div class="col-xl-12" style="border-right: 0px solid var(--bs-gray-300); padding:10px;text-align: center">
                            0000004
                            </div>
                        
                    </div>
                    

                    
                </div>



                <!--begin::Table-->
                
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Products-->
    </div>
    <!--end::Post-->
</div>
@endsection