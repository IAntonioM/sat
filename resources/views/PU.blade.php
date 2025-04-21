@extends('layouts.cabecera')
@section('content')
    <div class="card " style="background-image: url(assets/media/logos/fondo1.jpg);background-position: center center;">
        <div class="card-body pt-9 pb-0">
            <!--begin::Details-->
            <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
                <!--begin::Wrapper-->
                <div class="flex-grow-1">
                    <!--begin::Head-->
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <!--begin::Details-->
                        <div class="d-flex flex-column">
                            <!--begin::Status-->
                            <div class="d-flex align-items-center mb-1">
                                <span class="text-gray-800 text-primary fs-1 fw-bold me-3">Predio de Urbano (PU)</span>
                            </div>
                            <!--end::Status-->
                            <!--begin::Description-->
                            <div class="d-flex flex-wrap fw-semibold mb-4 fs-5 text-gray-400">Deudas del Contribuyente al
                                {{ $fechaActual }}</div>
                            <!--end::Description-->
                        </div>
                        <!--end::Details-->
                        <!--begin::Actions-->
                        <div class="d-flex mb-4">
                            <a href="{{ route('reporte', ['tipo' => 'reportePU', 'xid_anexo' => $datos_predio[0]->id_anexo ?? '']) }}"
                                class="btn btn-primary" id="btnImprimir">
                                <i class="fa-solid fa-print"></i> Imprimir
                            </a>
                        </div>
                        <!--end::Actions-->
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
                <div class="card-header align-items-center py-5 gap-2 gap-md-5" style="flex-wrap: initial">
                    <div class="col-xl-3"><img src="assets/media/logos/custom-3-h25-2.png" alt=""></div>
                    <div class="col-xl-6" style="text-align: center"><span class="fs-1">IMPUESTO PREDIAL
                            {{ $year }}</span><br>
                        <span class="fs-8">DECLARACIÓN JURADA</span><br>
                        <!--<span class="fs-8">T.U.O. DE LA LEY DE TRIBUTACIÓN MUNICIPAL (D.S.N° 156-2004-EF)</span>-->
                    </div>
                    <div class="col-xl-3" style="text-align: center"><span class="fs-1">PU</span><br><span>(Predio
                            Urbano)</span></div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <div class="col-xl-12" style="border: 0px solid var(--bs-gray-300); padding:10px;">
                        I. DATOS DEL CONTRIBUYENTE
                    </div>
                    <div class="col-xl-12 row"
                        style="border: 1px solid var(--bs-gray-300);margin-left: 0;margin-right:0;--bs-gutter-x: 0rem; margin-bottom:20px">
                        <div class="col-xl-8 row" style="margin-left: 0;margin-right:0;--bs-gutter-x: 0rem;">
                            <div class="col-xl-4"
                                style="font-size:10px;border-right: 1px solid var(--bs-gray-300);border-bottom: 0px solid var(--bs-gray-300); padding:30px;background-color:#f8f8f9;text-align: center ">
                                CONTRIBUYENTE:
                            </div>
                            <div class="col-xl-8"
                                style="font-size:10px;border-right: 1px solid var(--bs-gray-300);border-bottom: 0px solid var(--bs-gray-300); padding:30px;">
                                {{ $datos_predio[0]->nombre ?? 'N/A' }}
                            </div>
                        </div>
                        <div class="col-xl-4 row" style="margin-left: 0;margin-right:0;--bs-gutter-x: 0rem;">
                            <div class="col-xl-6 row">
                                <div class="col-xl-12 "
                                    style="font-size:10px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:12px;background-color:#f8f8f9;text-align: center ">
                                    CODIGO DE CONTRIBUYENTE
                                </div>
                                <div class="col-xl-12"
                                    style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                                    {{ $datos_predio[0]->codigo ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="col-xl-6 row">
                                <div class="col-xl-12 "
                                    style="font-size:10px;border-right: 0px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:12px;background-color:#f8f8f9;text-align: center ">
                                    CODIGO PREDIO
                                </div>
                                <div class="col-xl-12"
                                    style="border-right: 0px solid var(--bs-gray-300); padding:10px;text-align: center">
                                    {{ $datos_predio[0]->id_anexo ?? 'N/A' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 row"
                        style="border: 1px solid var(--bs-gray-300);margin-left: 0;margin-right:0;--bs-gutter-x: 0rem;">
                        <div class="col-xl-7 row" style="margin-left: 0;margin-right:0;--bs-gutter-x: 0rem;">
                            <div class="col-xl-4"
                                style="font-size:10px;border-right: 1px solid var(--bs-gray-300);border-bottom: 0px solid var(--bs-gray-300); padding:30px;background-color:#f8f8f9;text-align: center ">
                                DATOS DEL PREDIO
                            </div>
                            <div class="col-xl-8 row"
                                style="font-size:10px;border-right: 1px solid var(--bs-gray-300);border-bottom: 0px solid var(--bs-gray-300); padding:0px;">
                                <div class="col-xl-12"
                                    style="font-size:10px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                                    UBICACIÓN
                                </div>
                                <div class="col-xl-12"
                                    style="font-size:10px;border-right: 1px solid var(--bs-gray-300);border-bottom: 0px solid var(--bs-gray-300); padding:10px;">
                                    {{ $datos_predio[0]->direccion ?? ($vdirecc ?? 'N/A') }}
                                </div>
                            </div>

                        </div>
                        <div class="col-xl-5 row" style="margin-left: 0;margin-right:0;--bs-gutter-x: 0rem;">
                            <div class="col-xl-2 row">
                                <div class="col-xl-12 "
                                    style="font-size:10px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:12px;background-color:#f8f8f9;text-align: center ">
                                    CONDICIÓN
                                </div>
                                <div class="col-xl-12"
                                    style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                                    {{ $datos_predio[0]->id_condi ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="col-xl-4 row">
                                <div class="col-xl-12 "
                                    style="font-size:10px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:12px;background-color:#f8f8f9;text-align: center ">
                                    CONDICIÓN DE PROPIEDAD
                                </div>
                                <div class="col-xl-12"
                                    style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                                    {{ $datos_predio[0]->condi ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="col-xl-3 row">
                                <div class="col-xl-12 "
                                    style="font-size:10px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:12px;background-color:#f8f8f9;text-align: center ">
                                    USO DE PREDIO
                                </div>
                                <div class="col-xl-12"
                                    style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                                    {{ $datos_predio[0]->uso ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="col-xl-3 row">
                                <div class="col-xl-12 "
                                    style="font-size:9px;border-right: 0px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:12px;background-color:#f8f8f9;text-align: center ">
                                    %DE PROPIEDAD
                                </div>
                                <div class="col-xl-12"
                                    style="border-right: 0px solid var(--bs-gray-300); padding:10px;text-align: center">
                                    {{ number_format($datos_predio[0]->porcen ?? '0', 2) }}%
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12" style="border: 0px solid var(--bs-gray-300); padding:10px 10px;">
                        II. DETERMINACIÓN DE AUTOAVALUO
                    </div>

                    <div id="construccionesContainer">
                        <div class="col-xl-12 row construccion-row"
                            style="border: 1px solid var(--bs-gray-300);margin-left: 0;margin-right:0;--bs-gutter-x: 0rem;">
                            <div class="row" style="width: 5%">
                                <div class="col-xl-12"
                                    style="font-size:8px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center">
                                    NIVEL
                                </div>
                                <div class="col-xl-12"
                                    style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                                    {{ $datos_predio[0]->piso ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="row" style="width: 6%">
                                <div class="col-xl-12"
                                    style="font-size:8px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center">
                                    TIPO CONST.
                                </div>
                                <div class="col-xl-12"
                                    style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                                    {{ $datos_predio[0]->tipo ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="row" style="width: 5%">
                                <div class="col-xl-12"
                                    style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center">
                                    AÑO
                                </div>
                                <div class="col-xl-12"
                                    style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                                    {{ $datos_predio[0]->anio ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="row" style="width: 5%">
                                <div class="col-xl-12"
                                    style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center">
                                    CL
                                </div>
                                <div class="col-xl-12"
                                    style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                                    {{ $datos_predio[0]->cl ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="row" style="width: 5%">
                                <div class="col-xl-12"
                                    style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px 0px 10px 0px;background-color:#f8f8f9;text-align: center">
                                    MP
                                </div>
                                <div class="col-xl-12"
                                    style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                                    {{ $datos_predio[0]->mp ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="row" style="width: 8%">
                                <div class="col-xl-12"
                                    style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center">
                                    ESTADO
                                </div>
                                <div class="col-xl-12"
                                    style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                                    {{ $datos_predio[0]->estado ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="row" style="width: 15%">
                                <div class="col-xl-12"
                                    style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center">
                                    CATEGORIA (1)
                                    Mc Tc Pi Pv Rv Ba
                                </div>
                                <div class="col-xl-12"
                                    style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                                    {{ $datos_predio[0]->categoria ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="row" style="width: 6%">
                                <div class="col-xl-12"
                                    style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center">
                                    V.UNITARIO
                                </div>
                                <div class="col-xl-12"
                                    style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                                    {{ number_format($datos_predio[0]->val_unit ?? 0, 2) }}
                                </div>
                            </div>
                            <div class="row" style="width: 5%">
                                <div class="col-xl-12"
                                    style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center">
                                    INC.5%
                                </div>
                                <div class="col-xl-12"
                                    style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                                    {{ number_format($datos_predio[0]->incremento ?? 0, 2) }}
                                </div>
                            </div>
                            <div class="row" style="width: 8%">
                                <div class="col-xl-12"
                                    style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center">
                                    DEPRECIACIÓN
                                </div>
                                <div class="col-xl-12"
                                    style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                                    {{ number_format($datos_predio[0]->deprec ?? 0, 2) }}
                                </div>
                            </div>
                            <div class="row" style="width: 8%">
                                <div class="col-xl-12"
                                    style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px 0px 10px 0px;background-color:#f8f8f9;text-align: center">
                                    V.U.DEPRECIACIÓN
                                </div>
                                <div class="col-xl-12"
                                    style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                                    {{ number_format($datos_predio[0]->val_un_dep ?? 0, 2) }}
                                </div>
                            </div>
                            <div class="row" style="width: 7%">
                                <div class="col-xl-12"
                                    style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center">
                                    ÁREA CONST.
                                </div>
                                <div class="col-xl-12"
                                    style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                                    {{ number_format($datos_predio[0]->area_const ?? 0, 2) }}
                                </div>
                            </div>
                            <div class="row" style="width: 9%">
                                <div class="col-xl-12"
                                    style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center">
                                    ÁREA COM. CONST.
                                </div>
                                <div class="col-xl-12"
                                    style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                                    {{ number_format($datos_predio[0]->area_comun ?? 0, 2) }}
                                </div>
                            </div>
                            <div class="row" style="width: 8%">
                                <div class="col-xl-12"
                                    style="font-size:9px;border-right: 0px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center">
                                    VALOR CONST.
                                </div>
                                <div class="col-xl-12"
                                    style="border-right: 0px solid var(--bs-gray-300); padding:10px;text-align: center">
                                    {{ number_format($datos_predio[0]->val_const ?? 0, 2) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 row"
                        style="border: 1px solid var(--bs-gray-300);margin-left: 0;margin-right:0;--bs-gutter-x: 0rem;">
                        <div class="col-xl-8 row" style="padding: 20px 10px 20px 10px">
                            <div class="col-xl-4 row">
                                <div class="col-xl-6 " style="font-size:9px; padding:10px ;text-align: center ">
                                    <b>TOTAL ÁREA CONST.:</b>
                                </div>
                                <div class="col-xl-6" style="font-size:10px; padding:10px;text-align: center">
                                    {{ number_format($datos_predio[0]->area_const, 2) ?? '0.00' }}
                                    M2
                                </div>
                            </div>
                            <div class="col-xl-4 row">
                                <div class="col-xl-6 " style="font-size:9px; padding:10px;text-align: center ">
                                    <b>FECHA DE ADQUISICIÓN:</b>
                                </div>
                                <div class="col-xl-6" style="font-size:10px; padding:10px;text-align: center">
                                    {{ $datos_predio[0]->fec_resol ?? '--/--/----' }}
                                </div>
                            </div>
                            <div class="col-xl-4 row"></div>
                            <div class="col-xl-4 row">
                                <div class="col-xl-6 " style="font-size:9px; padding:10px;text-align: center ">
                                    <b>ÁREA DE TERRENO:</b>
                                </div>
                                <div class="col-xl-6" style="font-size:10px; padding:10px;text-align: center">
                                    {{ number_format($datos_predio[0]->area_terr, 2) ?? '0.00' }}
                                    M2
                                </div>
                            </div>
                            <div class="col-xl-4 row">
                                <div class="col-xl-6 " style="font-size:9px; padding:10px;text-align: center ">
                                    <b>ÁREA COMUN DE TERRENO:</b>
                                </div>
                                <div class="col-xl-6" style="font-size:10px; padding:10px;text-align: center">
                                    {{ number_format($datos_predio[0]->area_comun, 2) ?? '0.00' }}
                                    M2
                                </div>
                            </div>
                            <div class="col-xl-4 row">
                                <div class="col-xl-6 " style="font-size:9px; padding:10px;text-align: center ">
                                    <b>ARANCEL:</b>
                                </div>
                                <div class="col-xl-6" style="font-size:10px; padding:10px;text-align: center">
                                    {{ number_format($datos_predio[0]->arancel, 2) ?? '0.00' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 row"
                            style="padding: 20px 10px 20px 10px; border-left: 0px solid var(--bs-gray-300);margin-left: 0;margin-right:0;--bs-gutter-x: 0rem;">
                            <div class="col-xl-12 row">
                                <div class="col-xl-8 " style="font-size:9px; padding:10px;text-align: right ">
                                    <b>VALOR TOTAL DE LA CONSTRUCCIÓN:</b>
                                </div>
                                <div class="col-xl-4" style="font-size:11px; padding:10px;text-align: right">
                                    {{ number_format($datos_predio[0]->tot_constr, 2) ?? '0.00' }}
                                </div>
                            </div>
                            <div class="col-xl-12 row">
                                <div class="col-xl-8 " style="font-size:9px; padding:10px;text-align: right ">
                                    <b>VALOR DE OTRAS INSTALACIÓNES:</b>
                                </div>
                                <div class="col-xl-4" style="font-size:11px; padding:10px;text-align: right">
                                    {{ number_format($datos_predio[0]->ot_instal, 2) ?? '0.00' }}
                                </div>
                            </div>
                            <div class="col-xl-12 row">
                                <div class="col-xl-8 " style="font-size:9px; padding:10px;text-align: right ">
                                    <b>VALOR TOTAL DEL TERRENO:</b>
                                </div>
                                <div class="col-xl-4" style="font-size:11px; padding:10px;text-align: right">
                                    {{ number_format($datos_predio[0]->tot_terr, 2) ?? '0.00' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12 row" style="margin-left: 0;margin-right:0;--bs-gutter-x: 0rem;">
                        <div class="col-xl-6"
                            style="font-size:9px;border: 0px solid var(--bs-gray-300); padding:20px 0px 0px 0px;">
                            1). APROBADO MEDIANTE R.M. 367-2014 - VIVIENDA DEL MINISTERIO DE VIVIENDA, CONSTRUCCION Y
                            SANEAMIENTO<br>
                            2). APROBADO MEDIANTE R.M. 126-2007 - VIVIENDA DEL MINISTERIO DE VIVIENDA, CONSTRUCCION Y
                            SANEAMIENTO<br>
                            3). APROBADO MEDIANTE R.M. 369-2014 - VIVIENDA DEL MINISTERIO DE VIVIENDA, CONSTRUCCION Y
                            SANEAMIENTO
                        </div>
                        <div class="col-xl-6 row"
                            style="font-size:9px;border: 0px solid var(--bs-gray-300); padding:5px 0px 0px 0px;">
                            <div class="col-xl-10 " style="font-size:12px; padding:10px;text-align: right ">
                                <b>VALOR TOTAL DEL PREDIO:</b>
                            </div>
                            <div class="col-xl-2" style="font-size:12px; padding:10px 20px 10px 10px;text-align: right">
                                {{ number_format(
                                    ($datos_predio[0]->ot_instal ?? 0) + ($datos_predio[0]->tot_constr ?? 0) + ($datos_predio[0]->tot_terr ?? 0),
                                    2,
                                ) }}
                            </div>
                        </div>
                    </div>

                    <!-- Signature section -->
                    <div class="col-xl-12 row"
                        style="margin-left: 0;margin-right:0;--bs-gutter-x: 0rem; margin-top: 40px">
                        <div class="col-xl-6" style="text-align: center; padding: 30px 0px 0px 0px;">
                            <div style="border-top: 1px solid #000; width: 200px; margin: 0 auto;">
                                FIRMA DEL CONTRIBUYENTE
                            </div>
                        </div>
                        <div class="col-xl-6" style="text-align: center; padding: 30px 0px 0px 0px;">
                            <div style="border-top: 1px solid #000; width: 200px; margin: 0 auto;">
                                FIRMA Y SELLO DEL FUNCIONARIO
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Products-->
        </div>
        <!--end::Post-->
    </div>
@endsection
