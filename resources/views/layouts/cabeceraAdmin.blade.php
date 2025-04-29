<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <base href="" />
    <title>SAT-ICA</title>
    <meta charset="utf-8" />
    <meta name="description"
        content="The most advanced Bootstrap 5 Admin Theme with 40 unique prebuilt layouts on Themeforest trusted by 100,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel versions. Grab your copy now and get life-time updates for free." />
    <meta name="keywords"
        content="metronic, bootstrap, bootstrap 5, angular, VueJs, React, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel starter kits, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title"
        content="Metronic - Bootstrap Admin Template, HTML, VueJS, React, Angular. Laravel, Asp.Net Core, Ruby on Rails, Spring Boot, Blazor, Django, Express.js, Node.js, Flask Admin Dashboard Theme & Template" />
    <meta property="og:url" content="https://keenthemes.com/metronic" />
    <meta property="og:site_name" content="Keenthemes | Metronic" />
    <link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <script>
        // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }
    </script>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled">
    <!--begin::Theme mode setup on page load-->
    <script>
        // Set theme to light
        document.documentElement.setAttribute("data-bs-theme", "light");

        // Store the preference in localStorage
        localStorage.setItem("data-bs-theme", "light");

        // This will ensure the theme stays light even if system preferences change
        window.matchMedia("(prefers-color-scheme: dark)").addEventListener("change", () => {
          document.documentElement.setAttribute("data-bs-theme", "light");
        });
      </script>
    <!--end::Theme mode setup on page load-->
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <!--begin::Header-->
                <div id="kt_header" class="header align-items-stretch mb-5 mb-lg-10" data-kt-sticky="true"
                    data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
                    <!--begin::Container-->
                    <div class="container-xxl d-flex align-items-center">
                        <!--begin::Heaeder menu toggle-->
                        <div class="d-flex topbar align-items-center d-lg-none ms-n2 me-3" title="Show aside menu">
                            <div class="btn btn-icon btn-active-light-primary btn-custom w-30px h-30px w-md-40px h-md-40px"
                                id="kt_header_menu_mobile_toggle">
                                <i class="ki-duotone ki-abstract-14 fs-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                        </div>
                        <!--end::Heaeder menu toggle-->
                        <!--begin::Header Logo-->
                        <div class="header-logo me-5 me-md-10 flex-grow-1 flex-lg-grow-0">
                            <a href="{{ route('principal') }}">

                                <img alt="Logo" src="assets/media/logos/custom-3-h25.png" class="logo-default h-25px" />
                                <img alt="Logo" src="assets/media/logos/custom-3-h25-2.png" class="logo-sticky h-25px" />
                            </a>

                        </div>
                        <!--end::Header Logo-->
                        <!--begin::Wrapper-->
                        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
                            <!--begin::Navbar-->
                            <div class="d-flex align-items-stretch" id="kt_header_nav">
                                <!--begin::Menu wrapper-->
                                <div class="header-menu align-items-stretch" data-kt-drawer="true"
                                     data-kt-drawer-name="header-menu"
                                     data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
                                     data-kt-drawer-width="{default:'200px', '300px': '250px'}"
                                     data-kt-drawer-direction="start"
                                     data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true"
                                     data-kt-swapper-mode="prepend"
                                     data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
                                    <!--begin::Menu-->
                                    <div class="menu menu-rounded menu-column menu-lg-row menu-active-bg menu-title-gray-700 menu-state-primary menu-arrow-gray-400 fw-semibold my-5 my-lg-0 align-items-stretch px-2 px-lg-0"
                                         id="#kt_header_menu" data-kt-menu="true">
                                        <!--begin:Menu item-->
                                        @if($usuario->vestado == '002')
                                            <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                                 data-kt-menu-placement="bottom-start"
                                                 class="menu-item here show menu-here-bg menu-lg-down-accordion me-0 me-lg-2">
                                                <!--begin:Menu link-->
                                                <a href="{{ route('UsuariosAdmin') }}">
                                                    Mantenimiento de Usuarios
                                                </a>
                                                <!--end:Menu link-->
                                                <!--begin:Menu sub-->

                                                <!--end:Menu sub-->
                                            </div>
                                            <!--end:Menu item-->
                                        @endif

                                        <!--begin:Menu item-->
                                        @if($usuario->vestado == '002' || $usuario->vestado == '003')
                                            <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                                 data-kt-menu-placement="bottom-start"
                                                 class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                                <!--begin:Menu link-->
                                                <a href="{{ route('Pendiente') }}">Pendientes por Aprobar</a>
                                                <!--end:Menu link-->

                                            </div>
                                            <!--end:Menu item-->
                                        @endif
                                    </div>
                                    <!--end::Menu-->
                                </div>
                                <!--end::Menu wrapper-->
                            </div>
                            <!--end::Navbar-->

                            <!--end::Navbar-->
                            <!--begin::Toolbar wrapper-->
                            <div class="topbar d-flex align-items-stretch flex-shrink-0">





                                <!--begin::Theme mode-->

                                <!--end::Theme mode-->
                                <!--begin::User-->
                                <div class="d-flex align-items-center me-lg-n2 ms-1 ms-lg-3"
                                    id="kt_header_user_menu_toggle">
                                    <!--begin::Menu wrapper-->
                                    <div class="btn btn-icon btn-active-light-primary btn-custom w-30px h-30px w-md-40px h-md-40px"
                                        data-kt-menu-trigger="click" data-kt-menu-attach="parent"
                                        data-kt-menu-placement="bottom-end">
                                        <img class="h-30px w-30px rounded" src="assets/media/avatars/blank.png"
                                            alt="" />
                                    </div>
                                    <!--begin::User account menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                                        data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <div class="menu-content d-flex align-items-center px-3">
                                                <!--begin::Avatar-->
                                                <div class="symbol symbol-50px me-5">
                                                    <img alt="Logo"
                                                        src="{{ asset('assets/media/avatars/blank.png') }}" />
                                                </div>
                                                <!--end::Avatar-->
                                                <!--begin::Username-->
                                                <div class="d-flex flex-column">
                                                    <div class="fw-bold d-flex align-items-center fs-8">
                                                        {{ $usuario->vnombre ?? 'Usuario' }}
                                                        <!--<span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Pro</span>-->
                                                    </div>
                                                    <a href="#"
                                                        class="fw-semibold text-muted text-hover-primary fs-7">{{ $usuario->vcodcontr ?? 'Sin Codigo Contribuyente' }}</a>
                                                </div>
                                                <!--end::Username-->
                                            </div>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu separator-->
                                        <div class="separator my-2"></div>
                                        <!--end::Menu separator-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-5">
                                            <a href="{{ route('perfilAdmin') }}" class="menu-link px-5">Mi Perfil</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->

                                        <!--end::Menu item-->


                                        <!--begin::Menu separator-->
                                        <div class="separator my-2"></div>
                                        <!--end::Menu separator-->


                                        <!--begin::Menu item-->
                                        <div class="menu-item px-5">
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="menu-link px-5"
                                                    style="background: none; border: none; padding: 0; margin: 0; cursor: pointer;">
                                                    Cerrar Sesión
                                                </button>
                                            </form>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::User account menu-->
                                    <!--end::Menu wrapper-->
                                </div>
                                <!--end::User -->
                                <!--begin::Aside mobile toggle-->
                                <!--end::Aside mobile toggle-->
                            </div>
                            <!--end::Toolbar wrapper-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Header-->
                <!--begin::Toolbar-->
                <div class="toolbar py-5 pb-lg-15" id="kt_toolbar">
                    <!--begin::Container-->
                    <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
                        <!--begin::Page title-->
                        <div class="page-title d-flex flex-column me-3">
                            <!--begin::Title-->
                            <h1 class="d-flex text-white fw-bold my-1 fs-3">{{ $usuario->vnombre ?? 'Usuario' }}</h1>
                            <!--end::Title-->
                            <!--begin::Breadcrumb-->
                            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
                                <li class="breadcrumb-item text-white opacity-75">
                                    <i class="fa-solid fa-house text-white"
                                        style="padding-right: 5px; font-size: 9.5px;"></i>
                                    {{ $usuario->vdirec ?? 'Sin dirección registrada' }}
                                </li>

                            </ul>
                            <!--end::Breadcrumb-->
                        </div>
                        <!--end::Page title-->

                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Toolbar-->
                <!--begin::Container-->
                <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
                    <!--begin::Post-->
                    <div class="content flex-row-fluid" id="kt_content">

                        <!--begin::Row-->
                        <div class="row gy-5 g-xl-8">
                            @yield('content')


                        </div>

                    </div>
                    <!--end::Post-->
                </div>
                <!--end::Container-->
                <!--begin::Footer-->
                <div class="footer py-4 d-flex flex-lg-column pt-12 pb-10" id="kt_footer">
                    <!--begin::Container-->
                    <div class="container-xxl  flex-column flex-md-row align-items-center justify-content-between"
                        style="text-align: center;">
                        <!--begin::Copyright-->
                        <div class="text-dark order-2 order-md-1">
                            <span class="text-muted fw-semibold me-1">2025&copy;</span>
                            SAT-ICA - Servicio de Administración Tributaria de Ica
                        </div>

                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>

    <!--begin::Javascript-->
    <script>
        var hostUrl = "{{ asset('assets/') }}/";
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
    <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="assets/js/widgets.bundle.js"></script>
    <script src="assets/js/custom/widgets.js"></script>
    <script src="assets/js/custom/apps/chat/chat.js"></script>
    <script src="assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="assets/js/custom/utilities/modals/create-app.js"></script>
    <script src="assets/js/custom/utilities/modals/create-campaign.js"></script>
    <script src="assets/js/custom/utilities/modals/users-search.js"></script>

    <script src="assets/js/custom/apps/user-management/users/list/add.js"></script>
    <script src="{{ asset('assets/js/usuariosJS.js') }}?v={{ time() }}"></script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
</body>
@if (session('alert'))
    <script>
        Swal.fire({
            icon: '{{ session('alert.type') }}',
            title: '{{ session('alert.title') }}',
            html: `{!! session('alert.message') !!}`,
            confirmButtonText: 'Aceptar',
            customClass: {
                confirmButton: 'btn btn-light-{{ session('alert.type') === 'success'
                    ? 'success'
                    : (session('alert.type') === 'warning'
                        ? 'warning'
                        : (session('alert.type') === 'info'
                            ? 'info'
                            : (session('alert.type') === 'error'
                                ? 'danger'
                                : 'primary'))) }}'
            }
        });

    </script>
@endif
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Modal de añadir usuario
        @if(session('modal_open_add'))
            var addModal = new bootstrap.Modal(document.getElementById('kt_modal_add_user'), {
                backdrop: 'static',
                keyboard: false
            });
            addModal.show();

            // Agregar evento para limpiar después de cerrar
            document.getElementById('kt_modal_add_user').addEventListener('hidden.bs.modal', function () {
                document.body.classList.remove('modal-open');
                let backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }
            });
        @endif

        // Modal de editar usuario
        @if(session('modal_open_edit'))
            const userId = "{{ session('user_id') }}";
            const userButton = document.querySelector(`.editar-usuario[data-id="${userId}"]`);

            if (userButton) {
                userButton.click();
            }

            var editModal = new bootstrap.Modal(document.getElementById('kt_modal_edit_user'), {
                backdrop: 'static',
                keyboard: false
            });
            editModal.show();

            // Agregar evento para limpiar después de cerrar
            document.getElementById('kt_modal_edit_user').addEventListener('hidden.bs.modal', function () {
                document.body.classList.remove('modal-open');
                let backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }
            });
        @endif
    });
</script>

<!--end::Body-->

</html>
