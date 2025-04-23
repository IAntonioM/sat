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
                            <span class="text-gray-800 text-primary fs-1 fw-bold me-3">Predio de Rustico (PR)</span>
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
                <div class="col-xl-6" style="text-align: center"><span class="fs-1">IMPUESTO PREDIAL 2025</span><br>
                    <span class="fs-8">DECLARACIÓN JURADA</span><br>
                        <!--<span class="fs-8">T.U.O. DE LA LEY DE TRIBUTACIÓN MUNICIPAL (D.S.N° 156-2004-EF)</span>-->
                </div>
                <div class="col-xl-3" style="text-align: center"><span class="fs-1">PR</span><br><span>(Predio Rustico)</span></div>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0" >
                <div class="col-xl-12" style="border: 0px solid var(--bs-gray-300); padding:10px;">
                    I. DATOS DEL CONTRIBUYENTE 
                </div>
                <div class="col-xl-12 row" style="border: 1px solid var(--bs-gray-300);margin-left: 0;margin-right:0;--bs-gutter-x: 0rem; margin-bottom:20px">
                    <div class="col-xl-8 row" style="margin-left: 0;margin-right:0;--bs-gutter-x: 0rem;"> 
                        <div class="col-xl-4" style="font-size:10px;border-right: 1px solid var(--bs-gray-300);border-bottom: 0px solid var(--bs-gray-300); padding:30px;background-color:#f8f8f9;text-align: center ">
                            CONTRIBUYENTE:
                        </div>
                        <div class="col-xl-8" style="font-size:10px;border-right: 1px solid var(--bs-gray-300);border-bottom: 0px solid var(--bs-gray-300); padding:30px;">
                            j
                        </div>
                    </div>
                    <div class="col-xl-4 row" style="margin-left: 0;margin-right:0;--bs-gutter-x: 0rem;">
                        <div class="col-xl-6 row" >
                            <div class="col-xl-12 " style="font-size:10px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:12px;background-color:#f8f8f9;text-align: center ">
                                CODIGO DE CONTRIBUYENTE
                            </div>
                            <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                                0000004
                            </div>
                        </div>
                        <div class="col-xl-6 row" >
                            <div class="col-xl-12 " style="font-size:10px;border-right: 0px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:12px;background-color:#f8f8f9;text-align: center ">
                                CODIGO PREDIO
                            </div>
                            <div class="col-xl-12" style="border-right: 0px solid var(--bs-gray-300); padding:10px;text-align: center">
                                0000004
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 row" style="border: 1px solid var(--bs-gray-300);margin-left: 0;margin-right:0;--bs-gutter-x: 0rem;">
                    <div class="col-xl-7 row" style="margin-left: 0;margin-right:0;--bs-gutter-x: 0rem;"> 
                        <div class="col-xl-4" style="font-size:10px;border-right: 1px solid var(--bs-gray-300);border-bottom: 0px solid var(--bs-gray-300); padding:30px;background-color:#f8f8f9;text-align: center ">
                            DATOS DEL PREDIO
                        </div>
                        <div class="col-xl-8 row" style="font-size:10px;border-right: 1px solid var(--bs-gray-300);border-bottom: 0px solid var(--bs-gray-300); padding:0px;">
                            <div class="col-xl-12" style="font-size:10px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                                UBICACIÓN
                            </div>
                            <div class="col-xl-12" style="font-size:10px;border-right: 1px solid var(--bs-gray-300);border-bottom: 0px solid var(--bs-gray-300); padding:10px;">
                                j
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-xl-5 row" style="margin-left: 0;margin-right:0;--bs-gutter-x: 0rem;">
                        <div class="col-xl-2 row" >
                            <div class="col-xl-12 " style="font-size:10px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:12px;background-color:#f8f8f9;text-align: center ">
                                CONDICIÓN
                            </div>
                            <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                                0000004
                            </div>
                        </div>
                        <div class="col-xl-4 row" >
                            <div class="col-xl-12 " style="font-size:10px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:12px;background-color:#f8f8f9;text-align: center ">
                                CONDICIÓN DE PROPIEDAD
                            </div>
                            <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                                0000004
                            </div>
                        </div>
                        <div class="col-xl-3 row" >
                            <div class="col-xl-12 " style="font-size:10px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:12px;background-color:#f8f8f9;text-align: center ">
                                USO DE PREDIO
                            </div>
                            <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                                0000004
                            </div>
                        </div>
                        <div class="col-xl-3 row" >
                            <div class="col-xl-12 " style="font-size:9px;border-right: 0px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:12px;background-color:#f8f8f9;text-align: center ">
                                %DE PROPIEDAD
                            </div>
                            <div class="col-xl-12" style="border-right: 0px solid var(--bs-gray-300); padding:10px;text-align: center">
                                0000004
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12" style="border: 0px solid var(--bs-gray-300); padding:10px 10px;">
                    II. DETERMINACIÓN DE AUTOAVALUO
                </div>
                <div class="col-xl-12 row" style="border: 1px solid var(--bs-gray-300);margin-left: 0;margin-right:0;--bs-gutter-x: 0rem;">
                    <div class="row" style="width: 5%">
                        <div class="col-xl-12 " style="font-size:8px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center ">
                            NIVEL	
                        </div>
                        <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            0004
                        </div>
                    </div>
                    <div class="row" style="width: 6%">
                        <div class="col-xl-12 " style="font-size:8px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center ">
                            TIPO CONST.
                        </div>
                        <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            0004
                        </div>
                    </div>
                    <div class="row" style="width: 5%">
                        <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center ">
                            AÑO
                        </div>
                        <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            2025
                        </div>
                    </div>
                    <div class="row" style="width: 5%">
                        <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center ">
                            CL
                        </div>
                        <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            0004
                        </div>
                    </div>
                    <div class="row" style="width: 5%">
                        <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px 0px 10px 0px;background-color:#f8f8f9;text-align: center ">
                            MP
                        </div>
                        <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            0004
                        </div>
                    </div>
                    <div class="row" style="width: 8%">
                        <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center ">
                            ESTADO
                        </div>
                        <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            0000004
                        </div>
                    </div>
                    <div class="row" style="width: 15%">
                        <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center ">
                            CATEGORIA (1)
                            Mc Tc Pi Pv Rv Ba
                        </div>
                        <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            0000004
                        </div>
                    </div>
                    <div class="row" style="width: 6%">
                        <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center ">
                            V.UNITARIO	
                        </div>
                        <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            00004
                        </div>
                    </div>
                    <div class="row" style="width: 5%">
                        <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center ">
                            INC.5%
                        </div>
                        <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                        004
                        </div>
                    </div>
                    <div class="row" style="width: 8%">
                        <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center ">
                            DEPRECIACIÓN
                        </div>
                        <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            0000004
                        </div>
                    </div>
                    <div class="row" style="width: 8%">
                        <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px 0px 10px 0px;background-color:#f8f8f9;text-align: center ">
                            V.U.DEPRECIACIÓN
                        </div>
                        <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            0000004
                        </div>
                    </div>
                    <div class="row" style="width: 7%">
                        <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center ">
                            ÁREA CONST.
                        </div>
                        <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            0000004
                        </div>
                    </div>
                    <div class="row" style="width: 9%">
                        <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center ">
                            ÁREA COM. CONST.
                        </div>
                        <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            0000004
                        </div>
                    </div>
                    <div class="row" style="width: 8%">
                        <div class="col-xl-12 " style="font-size:9px;border-right: 0px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center ">
                            VALOR CONST.
                        </div>
                        <div class="col-xl-12" style="border-right: 0px solid var(--bs-gray-300); padding:10px;text-align: center">
                            0000004
                        </div>
                    </div>
                </div>
                <BR>

                <div class="col-xl-12 row" style="border: 1px solid var(--bs-gray-300);margin-left: 0;margin-right:0;--bs-gutter-x: 0rem;">
                    <div class="row" style="width: 60%">
                        <div class="col-xl-12 " style="font-size:8px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center ">
                            CLASES DE TIERRAS	
                        </div>
                        <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            0004
                        </div>
                        <div class="col-xl-12" style="border-top: 1px solid var(--bs-gray-300);border-right: 1px solid var(--bs-gray-300); padding:10px;">
                           (*)
                        </div>
                    </div>
                    <div class="row" style="width: 10%">
                        <div class="col-xl-12 " style="font-size:8px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center ">
                            CATEGORIA
                        </div>
                        <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            0004
                        </div>
                        <div class="col-xl-12" style="border-top: 1px solid var(--bs-gray-300);border-right: 1px solid var(--bs-gray-300); padding:10px;">
                            (*)
                         </div>
                    </div>
                    <div class="row" style="width: 10%">
                        <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center ">
                            ARANCEL
                        </div>
                        <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            2025
                        </div>
                        <div class="col-xl-12" style="border-top: 1px solid var(--bs-gray-300);border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            0.00
                         </div>
                    </div>
                    <div class="row" style="width: 10%">
                        <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center ">
                            CANT. DE HECTÁREAS
                        </div>
                        <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            0004
                        </div>
                        <div class="col-xl-12" style="border-top: 1px solid var(--bs-gray-300);border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            0.00000
                         </div>
                    </div>
                    <div class="row" style="width: 10%">
                        <div class="col-xl-12 " style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px 0px 10px 0px;background-color:#f8f8f9;text-align: center ">
                           ARANCEL X HA.
                        </div>
                        <div class="col-xl-12" style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            0004
                        </div>
                        <div class="col-xl-12" style="border-top: 1px solid var(--bs-gray-300);border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                            0.00
                         </div>
                    </div> 
                </div>

<br>





                <div class="col-xl-12 row" style="border: 1px solid var(--bs-gray-300);margin-left: 0;margin-right:0;--bs-gutter-x: 0rem;">
                    <div class="col-xl-8 row" style="padding: 20px 10px 20px 10px">
                        <div class="col-xl-4 row" >
                            <div class="col-xl-6 " style="font-size:9px; padding:10px ;text-align: center ">
                                <b>TOTAL ÁREA CONST.:</b>
                            </div>
                            <div class="col-xl-6" style="font-size:10px; padding:10px;text-align: center">
                                0.00 M2
                            </div>
                        </div>
                        <div class="col-xl-4 row" >
                            <div class="col-xl-6 " style="font-size:9px; padding:10px;text-align: center ">
                                <b>FECHA DE ADQUISICIÓN:</b>
                            </div>
                            <div class="col-xl-6" style="font-size:10px; padding:10px;text-align: center">
                                30/12/2023
                            </div>
                        </div>
                        <div class="col-xl-4 row" ></div>
                        
                        
                        
                    </div>
                    <div class="col-xl-4 row" style="padding: 20px 10px 20px 10px; border-left: 0px solid var(--bs-gray-300);margin-left: 0;margin-right:0;--bs-gutter-x: 0rem;">
                        <div class="col-xl-12 row" >
                            <div class="col-xl-8 " style="font-size:9px; padding:10px;text-align: right ">
                                <b>VALOR TOTAL DE LA CONSTRUCCIÓN:</b>
                            </div>
                            <div class="col-xl-4" style="font-size:11px; padding:10px;text-align: right">
                                0.00 
                            </div>
                        </div>
                        <div class="col-xl-12 row" >
                            <div class="col-xl-8 " style="font-size:9px; padding:10px;text-align: right ">
                                <b>VALOR DE OTRAS INSTALACIÓNES:</b>
                            </div>
                            <div class="col-xl-4" style="font-size:11px; padding:10px;text-align: right">
                                0.00 
                            </div>
                        </div>
                        <div class="col-xl-12 row" >
                            <div class="col-xl-8 " style="font-size:9px; padding:10px;text-align: right ">
                                <b>VALOR TOTAL DEL TERRENO:</b>
                            </div>
                            <div class="col-xl-4" style="font-size:11px; padding:10px;text-align: right">
                                0.00 
                            </div>
                        </div>
                    </div>
                </div>




                

            <div class="col-xl-12 row" style="margin-left: 0;margin-right:0;--bs-gutter-x: 0rem;">

                <div class="col-xl-6" style="font-size:9px;border: 0px solid var(--bs-gray-300); padding:20px 0px 0px 0px;">
                    1). APROBADO MEDIANTE R.M. 367-2014 - VIVIENDA DEL MINISTERIO DE VIVIENDA, CONSTRUCCION Y SANEAMIENTO<br>
                    2). APROBADO MEDIANTE R.M. 126-2007 - VIVIENDA DEL MINISTERIO DE VIVIENDA, CONSTRUCCION Y SANEAMIENTO<br>
                    3). APROBADO MEDIANTE R.M. 369-2014 - VIVIENDA DEL MINISTERIO DE VIVIENDA, CONSTRUCCION Y SANEAMIENTO
                </div>
                <div class="col-xl-6 row" style="font-size:9px;border: 0px solid var(--bs-gray-300); padding:5px 0px 0px 0px;">
                    <div class="col-xl-10 " style="font-size:12px; padding:10px;text-align: right ">
                        <b>VALOR TOTAL DEL PREDIO:</b>
                    </div>
                    <div class="col-xl-2" style="font-size:12px; padding:10px 20px 10px 10px;text-align: right">
                        0.00 
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