@extends('layouts.login')
@section('content')
<div class="d-flex  flex-lg-row-auto justify-content-center justify-content-lg-end p-12 ">
    <!--begin::Card-->
    <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-800px p-20 fade-in" style="background-image: url(assets/media/logos/fondo1.jpg);background-size: cover;background-position: center center;">
        <!--begin::Wrapper-->
        <div class="d-flex flex-center flex-column  px-lg-10  ">
            <!--begin::Form-->
            <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form"  method="POST" action="{{route('solicitarAcceso')}}" enctype="multipart/form-data">>
                <!--begin::Heading-->
                <div class="text-center mb-3">
                    <!--begin::Title-->
                    <h1 class="fw-bolder mb-3" style="color:#015e80;">SOLICITAR ACCESO A ESTADO DE CUENTA</h1>
                    <!--end::Title-->

                </div>
                <!--begin::Heading-->

                <!--begin::Separator-->
                <div class="separator separator-content my-14"></div>
                @csrf
                <div class="col-xl-12 row pb-5">
                    <div class="col-xl-6" style="padding: 0px 5px 0px 0px">
                        <select class="form-select bg-transparent"
                                name="iTipoDocuId"
                                data-control="select2"
                                data-hide-search="true"
                                data-placeholder="Seleccione el Tipo de Documento"
                                data-kt-ecommerce-order-filter="Seleccione el Tipo de Documento">
                            <option></option>
                            @foreach($tiposDocumento as $tipo)
                                <option value="{{ $tipo->id_doc }}">{{ trim($tipo->doc) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-xl-6" style="padding: 0px 0px 0px 5px">
                        <input type="text" placeholder="Nro. Documento" name="nNumDocuId" autocomplete="off" class="form-control bg-transparent" />
                    </div>
                </div>

                <div class="col-xl-12 pb-5" >

                    <div class="col-xl-12 " >
                        <input type="text" placeholder="Razón Social" name="cRazonSocial" autocomplete="off" class="form-control bg-transparent" />
                    </div>

                </div>
                <div class="col-xl-12 row pb-5 " >
                    <div class="col-xl-4 "  style="padding: 0px 5px 0px 0px">
                        <input type="text" placeholder="Apellido Paterno" name="cApePate" autocomplete="off" class="form-control bg-transparent" />
                    </div>
                    <div class="col-xl-4" style="padding: 0px 5px 0px 5px" >
                        <input type="text" placeholder="Apellido Materno" name="cApeMate" autocomplete="off" class="form-control bg-transparent" />
                    </div>
                    <div class="col-xl-4" style="padding: 0px 0px 0px 5px" >
                        <input type="text" placeholder="Nombres" name="cNombres" autocomplete="off" class="form-control bg-transparent" />
                    </div>
                </div>
                <!--end::Separator-->
                <!--begin::Input group=-->
                <div class="col-xl-12 row pb-5 " >
                    <!--begin::Email-->
                    <div class="col-xl-8 "  style="padding: 0px 5px 0px 0px">
                        <input type="text" placeholder="Email" name="correoDestino" autocomplete="off" class="form-control bg-transparent" />
                    </div>
                    <div class="col-xl-4 "  style="padding: 0px 0px 0px 5px">
                        <input type="text" placeholder="Telefóno" name="telefono" autocomplete="off" class="form-control bg-transparent" />
                    </div>
                    <!--end::Email-->
                </div>

                <div class="col-xl-12 row pb-5 " >
                    <!--begin::Email-->
                    <textarea class="form-control bg-transparent" name="cAsunto" placeholder="Asunto/Sumilla"></textarea>
                    <!--end::Email-->
                </div>

                <div class="col-xl-12 row pb-5 " >
                    <!--begin::Email-->
                    <input type="text" placeholder="Dirección" name="cDireccion" autocomplete="off" class="form-control bg-transparent" />
                    <!--end::Email-->
                </div>
                <div class="col-xl-12 row pb-5 " >
                    <!--begin::Email-->
                    <input type="file" placeholder="Archivo PDF/Imagen" name="archivo" autocomplete="off" class="form-control bg-transparent" />
                    <!--end::Email-->
                </div>
                <div class="col-xl-12 row pt-15 " >
                    <div class="col-xl-6 "  style="padding: 0px 5px 0px 0px">
                        <div class="d-grid mb-10">
                            <button  class="btn" style="color: #fff;border-color: #015e80;background-color: #015e80;">
                                <!--begin::Indicator label-->
                                <a href="{{ route('login')}}"></a>
                                <span class="indicator-label">REGRESAR</span>
                                <!--end::Indicator label-->
                                <!--begin::Indicator progress-->
                                <span class="indicator-progress">Espere por favor...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                <!--end::Indicator progress-->
                            </button>
                        </div>
                    </div>
                    <div class="col-xl-6 "  style="padding: 0px 0px 0px 5px">
                        <div class="d-grid mb-10">
                            <button type="submit"  class="btn" style="color: #fff;border-color: #015e80;background-color: #015e80;">
                                <!--begin::Indicator label-->
                                <span class="indicator-label">SOLICITAR ACCESO</span>
                                <!--end::Indicator label-->
                                <!--begin::Indicator progress-->
                                <span class="indicator-progress">Espere por favor...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                <!--end::Indicator progress-->
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Wrapper-->
        <!--begin::Footer-->

        <!--end::Footer-->
    </div>
    <!--end::Card-->
</div>
@endsection
