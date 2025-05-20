<div class="col-xl-3 row" style="margin: 0 1rem; border-left: 1px solid #f1f1f2;">
    <div class="card">
        <div class="card-header align-items-center py-5 gap-2 gap-md-5" style="padding: 0 1rem;">
            <div class="d-flex flex-wrap gap-2">
                <div class="form-check form-check-sm form-check-custom form-check-solid">
                    <input class="form-check-input" type="checkbox" data-kt-check="true"
                        data-kt-check-target="#kt_inbox_listing .form-check-input" value="1" />
                </div>
                <div class="d-flex align-items-center position-relative">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input type="text" wire:model="search" wire:keydown.enter="buscar"
                        class="form-control form-control-sm form-control-solid mw-120 min-w-120px min-w-lg-150px ps-11"
                        placeholder="Buscar por asunto" />

                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover table-row-dashed fs-6 gy-5 my-0" id="kt_inbox_listing">
                <thead class="d-none">
                    <tr>
                        <th>Checkbox</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($documentos as $documento)
                        <tr class="{{ $documento->estado_recepcion_id == 0 ? 'bg-light-warning' : '' }}">
                            <td class="ps-4">
                                <div class="form-check form-check-sm form-check-custom form-check-solid mt-3">
                                    <input class="form-check-input" type="checkbox"
                                        value="{{ $documento->correlativo ?? '' }}" />
                                </div>
                            </td>
                            <td>
                                <div class="text-dark gap-1 pt-2">
                                    <a href="#"
                                        wire:click.prevent="seleccionarDocumento('{{ $documento->correlativo }}')"
                                        class="text-primary {{ $documento->estado_recepcion_id == 0 ? 'fw-bolder' : '' }}"
                                        style="padding: 0 10px 0 0 ">
                                        <span class="fw-bold">{{ $documento->asunto ?? 'Sin asunto' }}</span>
                                        <br><span class="fw-semibold text-dark"
                                            style="font-size: 12px">{{ \Carbon\Carbon::parse($documento->fecha_recepcion)->format('d/m/Y H:i:s') ?? 'Sin fecha' }}</span>
                                    </a>
                                    @if ($documento->estado_recepcion_id == 0)
                                        <span class="badge badge-warning">No leído</span>
                                    @endif
                                    <div style="text-align: right">
                                        <a href="#" class="btn btn-sm btn-icon btn-light-warning"
                                            title="Archivar">
                                            <i class="ki-duotone ki-sms fs-2"><span class="path1"></span><span
                                                    class="path2"></span></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-icon btn-light-danger" title="Eliminar">
                                            <i class="ki-duotone ki-trash fs-2"><span class="path1"></span><span
                                                    class="path2"></span><span class="path3"></span><span
                                                    class="path4"></span><span class="path5"></span></i>
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center">No hay documentos emitidos.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
