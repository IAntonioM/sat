<div class="card-body">
    @if ($visible)
        <!--begin::Title-->
        <div class="d-flex flex-wrap gap-2 justify-content-between mb-8">
            <div class="d-flex align-items-center flex-wrap gap-2">
                <!--begin::Heading-->
                <h2 class="fw-semibold me-3 my-1">{{ $padre->asunto ?? 'Asunto no disponible' }}</h2>
                <!--begin::Heading-->
                <!--begin::Badges-->
                <span class="badge badge-light-primary my-1 me-2">inbox</span>
                <span class="badge badge-light-danger my-1">important</span>
                <!--end::Badges-->
            </div>
            <div class="d-flex">
                <!--begin::Sort-->
                <a href="#" class="btn btn-sm btn-icon btn-light btn-active-light-primary me-2"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Sort">
                    <i class="ki-duotone ki-arrow-up-down fs-2 m-0">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </a>
                <!--end::Sort-->
                <!--begin::Print-->
                <a href="#" class="btn btn-sm btn-icon btn-light btn-active-light-primary me-2"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Print">
                    <i class="ki-duotone ki-printer fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                        <span class="path4"></span>
                        <span class="path5"></span>
                    </i>
                </a>
                <!--end::Print-->
            </div>
        </div>

        <!--end::Title-->
        <!--begin::Message accordion-->
        <div data-kt-inbox-message="message_wrapper">
            <!--begin::Message header-->
            <div class="d-flex flex-wrap gap-2 flex-stack cursor-pointer" data-kt-inbox-message="header">
                <!--begin::Author-->
                <div class="d-flex align-items-center">
                    <!--begin::Avatar-->
                    <div class="symbol symbol-50 me-4">
                        <span class="symbol-label" style="background-image:url(assets/media/avatars/300-6.jpg);"></span>
                    </div>
                    <!--end::Avatar-->
                    <div class="pe-5">
                        <!--begin::Author details-->
                        <div class="d-flex align-items-center flex-wrap gap-1">
                            <a href="#"
                                class="fw-bold text-dark text-hover-primary">{{ $padre->nombre_emisor ?? 'Nombres Emisor no Disponible' }}</a>
                            <i class="ki-duotone ki-abstract-8 fs-7 text-success mx-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <span
                                class="text-muted fw-bold">({{ \Carbon\Carbon::parse($padre->fecha_creacion)->diffForHumans() }})</span>
                        </div>
                        <!--end::Author details-->
                        <!--begin::Message details-->
                        <div data-kt-inbox-message="details">
                            <span class="text-muted fw-semibold">to me</span>
                            <!--begin::Menu toggle-->
                            <a href="#" class="me-1" data-kt-menu-trigger="click"
                                data-kt-menu-placement="bottom-start">
                                <i class="ki-duotone ki-down fs-5 m-0"></i>
                            </a>
                            <!--end::Menu toggle-->
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-300px p-4"
                                data-kt-menu="true">
                                <!--begin::Table-->
                                <table class="table mb-0">
                                    <tbody>
                                        <tr>
                                            <td class="w-75px text-muted">From</td>
                                            <td>Emma Bold</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Date</td>
                                            <td>24 Jun 2023, 11:30 am</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Subject</td>
                                            <td>{{ $padre->asunto ?? 'Asunto no disponible' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Reply-to</td>
                                            <td>emma@intenso.com</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!--end::Menu-->
                        </div>
                        <!--end::Message details-->
                        <!--begin::Preview message-->
                        <div class="text-muted fw-semibold mw-450px d-none" data-kt-inbox-message="preview">With
                            resrpect, i
                            must disagree with Mr.Zinsser. We all know the most part of important part....</div>
                        <!--end::Preview message-->
                    </div>
                </div>
                <!--end::Author-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <!--begin::Date-->
                    <span
                        class="fw-semibold text-muted text-end me-3">{{ \Carbon\Carbon::parse($padre->fecha_creacion)->format('d M Y, h:i a') }}</span>
                    <!--end::Date-->
                    <div class="d-flex">
                        <!--begin::Star-->
                        <a href="#" class="btn btn-sm btn-icon btn-clear btn-active-light-primary me-3"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Star">
                            <i class="ki-duotone ki-star fs-2 m-0"></i>
                        </a>
                        <!--end::Star-->
                        <!--begin::Mark as important-->
                        <a href="#" class="btn btn-sm btn-icon btn-clear btn-active-light-primary me-3"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Mark as important">
                            <i class="ki-duotone ki-save-2 fs-2 m-0">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </a>
                        <!--end::Mark as important-->
                        <!--begin::Reply-->
                        <a href="#" class="btn btn-sm btn-icon btn-clear btn-active-light-primary me-3"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Reply">
                            <i class="ki-duotone ki-message-edit fs-2 m-0">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </a>
                        <!--end::Reply-->
                        <!--begin::Settings-->
                        <a href="#" class="btn btn-sm btn-icon btn-clear btn-active-light-primary"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Settings">
                            <i class="ki-duotone ki-dots-square-vertical fs-2 m-0">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                            </i>
                        </a>
                        <!--end::Settings-->
                    </div>
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Message header-->
            <!--begin::Message content-->
            <div class="collapse fade show" data-kt-inbox-message="message">
                <div class="py-5">
                    {{ $padre->contenido ?? '' }}
                    {{-- <p>Hi Bob,</p>
                <p>With resrpect, i must disagree with Mr.Zinsser. We all know the most part of important part of any
                    article is the title.Without a compelleing title, your reader won't even get to the first
                    sentence.After the title, however, the first few sentences of your article are certainly the most
                    important part.</p>
                <p>Jornalists call this critical, introductory section the "Lede," and when bridge properly executed,
                    it's the that carries your reader from an headine try at attention-grabbing to the body of your blog
                    post, if you want to get it right on of these 10 clever ways to omen your next blog posr with a bang
                </p>
                <p>Best regards,</p>
                <p class="mb-0">Jason Muller</p> --}}
                </div>
            </div>
            <!--end::Message content-->
        </div>
        @if (!empty($hijos) && count($hijos))
        @foreach ($hijos as $hijo)
        <!--end::Message accordion-->
        <div class="separator my-6"></div>
        <!--begin::Message accordion-->
        <div data-kt-inbox-message="message_wrapper">
            <!--begin::Message header-->
            <div class="d-flex flex-wrap gap-2 flex-stack cursor-pointer" data-kt-inbox-message="header">
                <!--begin::Author-->
                <div class="d-flex align-items-center">
                    <!--begin::Avatar-->
                    <div class="symbol symbol-50 me-4">
                        <span class="symbol-label"
                            style="background-image:url(assets/media/avatars/300-1.jpg);"></span>
                    </div>
                    <!--end::Avatar-->
                    <div class="pe-5">
                        <!--begin::Author details-->
                        <div class="d-flex align-items-center flex-wrap gap-1">
                            <a href="#" class="fw-bold text-dark text-hover-primary">{{ $hijo->nombre_emisor ?? 'Nombres Emisor no Disponible' }}</a>
                            <i class="ki-duotone ki-abstract-8 fs-7 text-success mx-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <span class="text-muted fw-bold">{{ \Carbon\Carbon::parse($hijo->fecha_creacion)->diffForHumans() }}</span>
                        </div>
                        <!--end::Author details-->
                        <!--begin::Message details-->
                        <div class="d-none" data-kt-inbox-message="details">
                            <span class="text-muted fw-semibold">to me</span>
                            <!--begin::Menu toggle-->
                            <a href="#" class="me-1" data-kt-menu-trigger="click"
                                data-kt-menu-placement="bottom-start">
                                <i class="ki-duotone ki-down fs-5 m-0"></i>
                            </a>
                            <!--end::Menu toggle-->
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-300px p-4"
                                data-kt-menu="true">
                                <!--begin::Table-->
                                <table class="table mb-0">
                                    <tbody>
                                        <tr>
                                            <td class="w-75px text-muted">From</td>
                                            <td>Emma Bold</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Date</td>
                                            <td>25 Oct 2023, 9:23 pm</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Subject</td>
                                            <td>Trip Reminder. Thank you for flying with us!</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Reply-to</td>
                                            <td>emma@intenso.com</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!--end::Menu-->
                        </div>
                        <!--end::Message details-->
                        <!--begin::Preview message-->
                        <div class="text-muted fw-semibold mw-450px" data-kt-inbox-message="preview">
                            {{ $hijo->contenido ?? '' }}
                            {{-- Jornalists call
                            this
                            critical, introductory section the "Lede," and when bridge properly executed.... --}}
                        </div>
                        <!--end::Preview message-->
                    </div>
                </div>
                <!--end::Author-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <!--begin::Date-->
                    <span class="fw-semibold text-muted text-end me-3">{{ \Carbon\Carbon::parse($hijo->fecha_creacion)->format('d M Y, h:i a') }}</span>
                    <!--end::Date-->
                    <div class="d-flex">
                        <!--begin::Star-->
                        <a href="#" class="btn btn-sm btn-icon btn-clear btn-active-light-primary me-3"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Star">
                            {{-- <i class="ki-duotone ki-star fs-2 text-warning m-0"></i> --}}
                            <i class="ki-duotone ki-star fs-2 text m-0"></i>
                        </a>
                        <!--end::Star-->
                        <!--begin::Mark as important-->
                        <a href="#" class="btn btn-sm btn-icon btn-clear btn-active-light-primary me-3"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Mark as important">
                            <i class="ki-duotone ki-save-2 fs-2 m-0">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </a>
                        <!--end::Mark as important-->
                        <!--begin::Reply-->
                        <a href="#" class="btn btn-sm btn-icon btn-clear btn-active-light-primary me-3"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Reply">
                            <i class="ki-duotone ki-message-edit fs-2 m-0">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </a>
                        <!--end::Reply-->
                        <!--begin::Settings-->
                        <a href="#" class="btn btn-sm btn-icon btn-clear btn-active-light-primary"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Settings">
                            <i class="ki-duotone ki-dots-square-vertical fs-2 m-0">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                            </i>
                        </a>
                        <!--end::Settings-->
                    </div>
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Message header-->
            <!--begin::Message content-->
            <div class="collapse fade" data-kt-inbox-message="message">
                <div class="py-5">
                    <p>Hi Bob,</p>
                    <p>With resrpect, i must disagree with Mr.Zinsser. We all know the most part of important part of
                        any
                        article is the title.Without a compelleing title, your reader won't even get to the first
                        sentence.After the title, however, the first few sentences of your article are certainly the
                        most
                        important part.</p>
                    <p>Jornalists call this critical, introductory section the "Lede," and when bridge properly
                        executed,
                        it's the that carries your reader from an headine try at attention-grabbing to the body of your
                        blog
                        post, if you want to get it right on of these 10 clever ways to omen your next blog posr with a
                        bang
                    </p>
                    <p>Best regards,</p>
                    <p class="mb-0">Jason Muller</p>
                </div>
            </div>
            <!--end::Message content-->
        </div>
        @endforeach
        @else
            <p class="text-muted">No hay documentos relacionados.</p>
        @endif
        {{-- <!--end::Message accordion-->
        <div class="separator my-6"></div>
        <!--begin::Message accordion-->
        <div data-kt-inbox-message="message_wrapper">
            <!--begin::Message header-->
            <div class="d-flex flex-wrap gap-2 flex-stack cursor-pointer" data-kt-inbox-message="header">
                <!--begin::Author-->
                <div class="d-flex align-items-center">
                    <!--begin::Avatar-->
                    <div class="symbol symbol-50 me-4">
                        <span class="symbol-label"
                            style="background-image:url(assets/media/avatars/300-5.jpg);"></span>
                    </div>
                    <!--end::Avatar-->
                    <div class="pe-5">
                        <!--begin::Author details-->
                        <div class="d-flex align-items-center flex-wrap gap-1">
                            <a href="#" class="fw-bold text-dark text-hover-primary">Sean Bean</a>
                            <i class="ki-duotone ki-abstract-8 fs-7 text-success mx-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <span class="text-muted fw-bold">3 days ago</span>
                        </div>
                        <!--end::Author details-->
                        <!--begin::Message details-->
                        <div class="d-none" data-kt-inbox-message="details">
                            <span class="text-muted fw-semibold">to me</span>
                            <!--begin::Menu toggle-->
                            <a href="#" class="me-1" data-kt-menu-trigger="click"
                                data-kt-menu-placement="bottom-start">
                                <i class="ki-duotone ki-down fs-5 m-0"></i>
                            </a>
                            <!--end::Menu toggle-->
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-300px p-4"
                                data-kt-menu="true">
                                <!--begin::Table-->
                                <table class="table mb-0">
                                    <tbody>
                                        <tr>
                                            <td class="w-75px text-muted">From</td>
                                            <td>Emma Bold</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Date</td>
                                            <td>20 Dec 2023, 6:05 pm</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Subject</td>
                                            <td>Trip Reminder. Thank you for flying with us!</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Reply-to</td>
                                            <td>emma@intenso.com</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!--end::Menu-->
                        </div>
                        <!--end::Message details-->
                        <!--begin::Preview message-->
                        <div class="text-muted fw-semibold mw-450px" data-kt-inbox-message="preview">Jornalists call
                            this
                            critical, introductory section the "Lede," and when bridge properly executed....</div>
                        <!--end::Preview message-->
                    </div>
                </div>
                <!--end::Author-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <!--begin::Date-->
                    <span class="fw-semibold text-muted text-end me-3">25 Oct 2023, 11:30 am</span>
                    <!--end::Date-->
                    <div class="d-flex">
                        <!--begin::Star-->
                        <a href="#" class="btn btn-sm btn-icon btn-clear btn-active-light-primary me-3"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Star">
                            <i class="ki-duotone ki-star fs-2 m-0"></i>
                        </a>
                        <!--end::Star-->
                        <!--begin::Mark as important-->
                        <a href="#" class="btn btn-sm btn-icon btn-clear btn-active-light-primary me-3"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Mark as important">
                            <i class="ki-duotone ki-save-2 fs-2 m-0">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </a>
                        <!--end::Mark as important-->
                        <!--begin::Reply-->
                        <a href="#" class="btn btn-sm btn-icon btn-clear btn-active-light-primary me-3"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Reply">
                            <i class="ki-duotone ki-message-edit fs-2 m-0">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </a>
                        <!--end::Reply-->
                        <!--begin::Settings-->
                        <a href="#" class="btn btn-sm btn-icon btn-clear btn-active-light-primary"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Settings">
                            <i class="ki-duotone ki-dots-square-vertical fs-2 m-0">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                            </i>
                        </a>
                        <!--end::Settings-->
                    </div>
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Message header-->
            <!--begin::Message content-->
            <div class="collapse fade" data-kt-inbox-message="message">
                <div class="py-5">
                    <p>Hi Bob,</p>
                    <p>With resrpect, i must disagree with Mr.Zinsser. We all know the most part of important part of
                        any
                        article is the title.Without a compelleing title, your reader won't even get to the first
                        sentence.After the title, however, the first few sentences of your article are certainly the
                        most
                        important part.</p>
                    <p>Jornalists call this critical, introductory section the "Lede," and when bridge properly
                        executed,
                        it's the that carries your reader from an headine try at attention-grabbing to the body of your
                        blog
                        post, if you want to get it right on of these 10 clever ways to omen your next blog posr with a
                        bang
                    </p>
                    <p>Best regards,</p>
                    <p class="mb-0">Jason Muller</p>
                </div>
            </div>
            <!--end::Message content-->
        </div>
        <!--end::Message accordion-->
        <!--begin::Form--> --}}
        @if ($visible)
            <livewire:emitir-mensaje.emitir-mensaje-component
                :padre="$padre"
                :key="'emitir-mensaje-' . $padre->nu_emi" />
        @endif

    @endif
    <!--end::Form-->
</div>
