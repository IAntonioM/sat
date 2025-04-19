@extends('layouts.login')
@section('content')
				<!--begin::Body-->
				<div class="d-flex  flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
					<!--begin::Card-->
					<div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-500px p-20 fade-in" style="background-image: url(assets/media/logos/fondo1.jpg);background-size: cover;background-position: center center;">
						<!--begin::Wrapper-->
						<div class="d-flex flex-center flex-column  px-lg-10  ">
							<!--begin::Form-->
							<form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" method="POST" action="{{route('cambiarClave')}}">
                            <!--<form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" data-kt-redirect-url="../../demo2/dist/index.html" action="#">-->
								<!--begin::Heading-->
                                @csrf
								<div class="text-center mb-11">
									<!--begin::Title-->
									<h1 class="fw-bolder mb-3" style="color:#015e80;">CAMBIAR EL PASSWORD</h1>
									<!--end::Title-->

								</div>
								<!--begin::Heading-->

								<!--begin::Separator-->
								<div class="separator separator-content my-14">

								</div>
								<!--end::Separator-->
								<!--begin::Input group=-->
								<div class="fv-row mb-8">
									<!--begin::Email-->
									<input type="text" placeholder="Usuario" name="usuario" autocomplete="off" class="form-control bg-transparent" value="{{ old('usuario', $usuario->vcodcontr ?? '') }}"  readonly/>
									<!--end::Email-->
								</div>
								<!--end::Input group=-->
								<div class="fv-row mb-3">
									<!--begin::Password-->
									<input type="password" placeholder="Actual Password" name="password" autocomplete="off" class="form-control bg-transparent" />
                                    @error('password')
                                    <div style="color: #d12d2d">{{ $message }}</div>
                                    @enderror
                                    <!--end::Password-->
								</div>
								<!--end::Input group=-->

								<!--end::Input group=-->
								<div class="fv-row mb-3">
									<!--begin::Password-->
									<input type="password" placeholder="Cambiar Password" name="password1" autocomplete="off" class="form-control bg-transparent" />
                                    @error('password1')
                                    <div style="color: #d12d2d">{{ $message }}</div>
                                    @enderror
                                    <!--end::Password-->
								</div>
								<!--end::Input group=-->
								<!--begin::Wrapper-->
								{{-- <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
									<div></div>
									<!--begin::Link-->
									<a href="../../demo2/dist/authentication/layouts/creative/reset-password.html" style="color: #015e80;">Has olvidado tu contraseña ?</a>
									<!--end::Link-->
								</div> --}}
								<!--end::Wrapper-->
								<!--begin::Submit button-->
								<div class="d-grid mb-10">
									{{-- <button type="submit" id="kt_sign_in_submit" class="btn" style="color: #fff;border-color: #015e80;background-color: #015e80;"> --}}
                                    <button type="submit"   class="btn" style="color: #fff;border-color: #015e80;background-color: #015e80;">
                                        <!--begin::Indicator label-->
										<span class="indicator-label">CAMBIAR CLAVE</span>
										<!--end::Indicator label-->
										<!--begin::Indicator progress-->
										<span class="indicator-progress">Espere por favor...
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
										<!--end::Indicator progress-->
									</button>
								</div>
                                {{-- <div class="d-grid mb-10">
									<button  id="kt_sign_in_submit" class="btn" style="color: #fff;border-color: #015e80;background-color: #015e80;">
										<!--begin::Indicator label-->
										<span class="indicator-label">SOLICITAR ACCESO</span>
										<!--end::Indicator label-->
										<!--begin::Indicator progress-->
										<span class="indicator-progress">Espere por favor...
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
										<!--end::Indicator progress-->
									</button>
								</div> --}}
								<!--end::Submit button-->

							</form>
							<!--end::Form-->
						</div>
						<!--end::Wrapper-->
						<!--begin::Footer-->

						<!--end::Footer-->
					</div>
					<!--end::Card-->
				</div>

				<!--end::Body-->
				@endsection
