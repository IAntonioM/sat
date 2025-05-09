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
                                <span class="text-gray-800 text-primary fs-1 fw-bold me-3">Hoja de Resumen (HR)</span>
                                <!--<span class="badge badge-light-success me-auto">In Progress</span>-->
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
                            <a href="{{ route('reporte', ['tipo' => 'reporteHR']) }}" class="btn btn-primary" target="_blank"><i class="fa-solid fa-print"></i>Imprimir</a>
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
                    <div class="col-xl-6" style="text-align: center"><span class="fs-1">IMPUESTO PREDIAL 2025</span><br>
                        <span class="fs-8">DECLARACIÓN JURADA</span><br>
                        <span class="fs-8">T.U.O. DE LA LEY DE TRIBUTACIÓN MUNICIPAL (D.S.N° 156-2004-EF)</span>
                    </div>
                    <div class="col-xl-3" style="text-align: center"><span class="fs-1">HR</span><br><span>(Hoja de
                            Resumen)</span></div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <div class="col-xl-12" style="border: 0px solid var(--bs-gray-300); padding:10px;">
                        I. DATOS DEL CONTRIBUYENTE
                    </div>
                    <div class="col-xl-12 row"
                        style="border: 1px solid var(--bs-gray-300);margin-left: 0;margin-right:0;--bs-gutter-x: 0rem;">

                        <div class="col-xl-8 row" style="margin-left: 0;margin-right:0;--bs-gutter-x: 0rem;">
                            <div class="col-xl-4"
                                style="font-size:10px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center ">
                                CONTRIBUYENTE:
                            </div>
                            <div class="col-xl-8"
                                style="font-size:10px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;">
                                {{ $contribuyente->nombre }}
                            </div>

                            <div class="col-xl-4"
                                style="font-size:10px;border-right: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center ">
                                DOMICILIO FISCAL:
                            </div>
                            <div class="col-xl-8"
                                style="font-size:10px;border-right: 1px solid var(--bs-gray-300); padding:10px;">
                                {{ $contribuyente->direcc }}
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
                                    {{ $contribuyente->codigo1 }}
                                </div>

                            </div>
                            <div class="col-xl-6 row">

                                <div class="col-xl-12 "
                                    style="font-size:10px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:12px;background-color:#f8f8f9;text-align: center ">
                                    DOCUMENTO
                                </div>

                                <div class="col-xl-12"
                                    style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                                    @if(isset($contribuyente->num_doc) && trim($contribuyente->num_doc) !== '')
                                        {{ $contribuyente->num_doc }}
                                    @else
                                        &nbsp;
                                    @endif
                                </div>

                            </div>





                        </div>
                    </div>
                    <!-- Header for Properties Table -->
<div class="col-xl-12" style="border: 0px solid var(--bs-gray-300); padding:10px;">
    II. RELACIÓN DE PREDIOS
</div>

<!-- Single Header Row -->
<div class="col-xl-12 row" style="border: 1px solid var(--bs-gray-300);margin-left: 0;margin-right:0;--bs-gutter-x: 0rem;">
    <!-- CODIGO HEADER -->
    <div class="col-xl-1" style="font-size:9px; border-right: 1px solid #ccc; padding:10px; background:#f8f8f9; text-align:center;">
        TIPO
    </div>

    <div class="col-xl-1" style="font-size:9px; border-right: 1px solid #ccc; padding:10px; background:#f8f8f9; text-align:center;">
        CÓDIGO
    </div>

    <!-- DIRECCIÓN HEADER -->
    <div class="col-xl-6" style="font-size:9px; border-right: 1px solid #ccc; padding:10px; background:#f8f8f9; text-align:center;">
        DIRECCIÓN DE PREDIO
    </div>

    <!-- VALOR PREDIO HEADER -->
    <div class="col-xl-1" style="font-size:9px; border-right: 1px solid #ccc; padding:10px; background:#f8f8f9; text-align:center;">
        S/. VALOR PREDIO
    </div>

    <!-- % PROPIEDAD HEADER -->
    <div class="col-xl-1" style="font-size:9px; border-right: 1px solid #ccc; padding:10px; background:#f8f8f9; text-align:center;">
        % PROPIEDAD
    </div>

    <!-- MONTO INAFECTO HEADER -->
    <div class="col-xl-1" style="font-size:9px; border-right: 1px solid #ccc; padding:10px; background:#f8f8f9; text-align:center;">
        MONTO INAFECTO
    </div>

    <!-- VALOR AFECTO HEADER -->
    <div class="col-xl-1" style="font-size:9px; border-right: 1px solid #ccc; padding:10px; background:#f8f8f9; text-align:center;">
        S/. VALOR AFECTO
    </div>
</div>

<!-- Data Rows -->
@forelse ($relacionPredios as $predio)
    <div class="col-xl-12 row" style="border: 1px solid var(--bs-gray-300);margin-left: 0;margin-right:0;--bs-gutter-x: 0rem; border-top: none;">
        <!-- CODIGO DATA -->
        <div class="col-xl-1" style="border-right: 1px solid #ccc; padding:10px; text-align:center;">
            {{ trim($predio->tipo_predio) }}
        </div>
        <div class="col-xl-1" style="border-right: 1px solid #ccc; padding:10px; text-align:center;">
            <a href="{{ $predio->tipo_predio == 'PR' ? url('PR?xid_anexo=' . trim($predio->cod_pred)) : url('PU?xid_anexo=' . trim($predio->cod_pred)) }}"
               style="color: rgb(0, 54, 233); text-decoration: underline; font-size: 12px;">
                {{ trim($predio->cod_pred) }}
            </a>
        </div>

        <!-- DIRECCIÓN DATA -->
        <div class="col-xl-6" style="border-right: 1px solid #ccc; padding:10px; text-align:center;">
            {{ str_replace('Âº', 'º', $predio->direccion) }}
        </div>

        <!-- VALOR PREDIO DATA -->
        <div class="col-xl-1" style="border-right: 1px solid #ccc; padding:10px; text-align:center;">
            {{ number_format($predio->val_autoavaluo, 2) }}
        </div>

        <!-- % PROPIEDAD DATA -->
        <div class="col-xl-1" style="border-right: 1px solid #ccc; padding:10px; text-align:center;">
            {{ $predio->porcen_propiedad }}
        </div>

        <!-- MONTO INAFECTO DATA -->
        <div class="col-xl-1" style="border-right: 1px solid #ccc; padding:10px; text-align:center;">
            {{ number_format($predio->total, 2) }}
        </div>

        <!-- VALOR AFECTO DATA -->
        <div class="col-xl-1" style="border-right: 1px solid #ccc; padding:10px; text-align:center;">
            {{ number_format($predio->Valor_Afecto, 2) }}
        </div>
    </div>
    @empty
        <div class="col-xl-12 row" style="border: 1px solid var(--bs-gray-300);margin-left: 0;margin-right:0;--bs-gutter-x: 0rem; border-top: none;">
            <div class="col-xl-12" style="border-right: 1px solid #ccc; padding:10px; text-align:center;">

            </div>
    </div>
@endforelse

                    <div class="col-xl-12" style="border: 0px solid var(--bs-gray-300); padding:10px;">
                        III. DETERMINACIÓN DE IMPUESTOS
                    </div>
                    <div class="col-xl-12 row"
                        style="border: 1px solid var(--bs-gray-300);margin-left: 0;margin-right:0;--bs-gutter-x: 0rem;">
                        <div class="col-xl-1 row">
                            <div class="col-xl-12"
                                style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center">
                                TOTAL PREDIOS
                            </div>
                            <div class="col-xl-12"
                                style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                                {{ number_format($totales['total_predios'], 0) }}
                            </div>
                        </div>
                        <div class="col-xl-1 row">
                            <div class="col-xl-12"
                                style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center">
                                PREDIOS AFECTO
                            </div>
                            <div class="col-xl-12"
                                style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                                {{ number_format($totales['total_afecto'], 0) }}
                            </div>
                        </div>
                        <div class="col-xl-1 row">
                            <div class="col-xl-12"
                                style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center">
                                BASE IMPONIBLE
                            </div>
                            <div class="col-xl-12"
                                style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                                {{ number_format($totales['base_imponible'], 2) }}
                            </div>
                        </div>
                        <div class="col-xl-1 row">
                            <div class="col-xl-12"
                                style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center">
                                BASE EXONERADA
                            </div>
                            <div class="col-xl-12"
                                style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                                {{ number_format($totales['base_exonerada'], 2) }}
                            </div>
                        </div>
                        <div class="col-xl-2 row">
                            <div class="col-xl-12"
                                style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px 0px 10px 0px;background-color:#f8f8f9;text-align: center">
                                IMPUESTO ANUAL
                            </div>
                            <div class="col-xl-12"
                                style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                                {{ number_format($totales['imp_anual'], 2) }}
                            </div>
                        </div>
                        <div class="col-xl-2 row">
                            <div class="col-xl-12"
                                style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center">
                                CUOTA TRIMESTRAL
                            </div>
                            <div class="col-xl-12"
                                style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                                {{ number_format($totales['imp_trime'], 2) }}
                            </div>
                        </div>
                        <div class="col-xl-2 row">
                            <div class="col-xl-12"
                                style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px 0px 10px 0px;background-color:#f8f8f9;text-align: center">
                                EMISIÓN Y DISTRIBUCIÓN
                            </div>
                            <div class="col-xl-12"
                                style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                                {{ number_format($totales['costo_emi'], 2) }}
                            </div>
                        </div>
                        <div class="col-xl-2 row">
                            <div class="col-xl-12"
                                style="font-size:9px;border-right: 1px solid var(--bs-gray-300);border-bottom: 1px solid var(--bs-gray-300); padding:10px;background-color:#f8f8f9;text-align: center">
                                TOTAL A PAGAR
                            </div>
                            <div class="col-xl-12"
                                style="border-right: 1px solid var(--bs-gray-300); padding:10px;text-align: center">
                                {{ number_format($totales['total'], 2) }}
                            </div>
                        </div>
                    </div>



                    <div class="col-xl-12"
                        style="font-size:9px;border: 0px solid var(--bs-gray-300); padding:20px 0px 0px 0px;">
                        Base Legal: Último párrafo del Art. 14 del TUO de la ley de Tributación Municipal, aprobada mediante
                        el D.S. 156-2004-EF
                    </div>
                    <div class="col-xl-12"
                        style="font-size:10px;border: 0px solid var(--bs-gray-300); padding:5px 0px 10px 0px;">
                        ESTA INFORMACIÓN TENDRA EFECTOS LEGALES DE LA DECLARACIÓN JURADA DE AUTOVALUO PARA EL PRESENTE AÑO,
                        SI NO PRESENTA OBSERVACIÓN ALGUNA HASTA EL 28 DE FEBRERO 2020 DENTRO DE 30 DIAS DE RECEPCIONADA.
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
