<div class="col-xl-3 row" style="margin: 0 1rem; border-left: 1px solid #f1f1f2;">
    <div class="card">
        <div class="card-header align-items-center py-5 gap-2 gap-md-5" style="padding: 0 1rem;">
            <div class="d-flex flex-wrap gap-2">
                <div class="form-check form-check-sm form-check-custom form-check-solid">
                    <!-- CORREGIDO: Mejorar la lógica del checkbox "Seleccionar todos" -->
                    <input class="form-check-input" type="checkbox" wire:click="toggleTodos"
                        {{ $stats['todos_visibles_seleccionados'] ? 'checked' : '' }}
                        title="Seleccionar/Deseleccionar todos" />
                </div>
                <div class="d-flex align-items-center position-relative">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input type="text"
       wire:model="search"
       wire:keydown.enter="buscar"
       class="form-control form-control-sm form-control-solid mw-120 min-w-120px min-w-lg-150px ps-11"
       placeholder="Buscar por asunto" />

                </div>
            </div>

            <!-- NUEVO: Mostrar contador de seleccionados -->
            @if (count($json_recibido) > 0)
                <div class="badge badge-light-primary">
                    {{ count($json_recibido) }} seleccionado{{ count($json_recibido) > 1 ? 's' : '' }}
                </div>
            @endif
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
                    @forelse ($documentos as $index => $documento)
                        <!-- CRÍTICO: Agregar wire:key único para cada fila -->
                        <tr wire:key="documento-{{ $documento->nu_emi }}-{{ $index }}">
                            <td class="ps-4">
                                <div class="form-check form-check-sm form-check-custom form-check-solid mt-3">
                                    <!-- CORREGIDO: Mejorar el checkbox individual -->
                                    <input class="form-check-input document-checkbox" type="checkbox"
                                        value="{{ $documento->nu_emi ?? '' }}"
                                        wire:click="toggleRecibido('{{ $documento->nu_emi }}')"
                                        {{ in_array($documento->nu_emi, $json_recibido) ? 'checked' : '' }}
                                        wire:key="checkbox-{{ $documento->nu_emi }}" />
                                </div>
                                {{-- <small class="text-muted">{{ $documento->nu_emi ?? '' }}</small> --}}
                            </td>
                            <td>
                                <div class="text-dark gap-1 pt-2">
                                    <a href="#"
                                        wire:click.prevent="seleccionarDocumento('{{ $documento->nu_emi }}')"
                                        class="text-primary {{ $documento->estado_recepcion_id == 0 ? 'fw-bolder' : '' }}"
                                        style="padding: 0 10px 0 0">
                                        <span class="fw-bold">{{ $documento->asunto ?? 'Sin asunto' }}</span>
                                        <br><span class="fw-semibold text-dark"
                                            style="font-size: 12px">{{ \Carbon\Carbon::parse($documento->fecha_recepcion)->format('d/m/Y H:i:s') ?? 'Sin fecha' }}</span>
                                    </a>
                                    @if ($documento->estado_recepcion_id == 0)
                                        <span class="badge badge-warning">No leído</span>
                                    @endif
                                    <div style="text-align: right">
                                        {{-- <a href="#" class="btn btn-sm btn-icon btn-light-warning"
                                            title="Archivar">
                                            <i class="ki-duotone ki-sms fs-2"><span class="path1"></span><span
                                                    class="path2"></span></i>
                                        </a> --}}
                                        <a href="#"
                                        wire:click.prevent="marcarMarcador('{{ $documento->nu_emi }}')"
                                        class="btn btn-sm btn-icon btn-clear btn-active-light-primary me-3"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Marcador">
                                            <i class="ki-duotone ki-save-2 fs-2 m-0
                                                {{ $documento->flag_marcador == 1 ? 'text-warning' : '' }}">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-icon btn-light-danger"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Mandar a Papelera" >
                                            <i class="ki-duotone ki-trash fs-2"><span class="path1"></span><span
                                                    class="path2"></span><span class="path3"></span><span
                                                    class="path4"></span><span class="path5"></span></i>
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr wire:key="empty-row">
                            <td colspan="2" class="text-center">No hay documentos emitidos.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- <!-- NUEVO: Panel de acciones para documentos seleccionados -->
        @if (count($json_recibido) > 0)
            <div class="card-footer d-flex justify-content-between align-items-center">
                <button type="button" class="btn btn-sm btn-light-danger"
                    wire:click="limpiarSeleccion"
                    title="Limpiar selección">
                    <i class="ki-duotone ki-cross fs-3">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    Limpiar
                </button>

                <button type="button" class="btn btn-sm btn-primary"
                    wire:click="procesarSeleccionados"
                    title="Procesar documentos seleccionados">
                    <i class="ki-duotone ki-check fs-3">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    Procesar ({{ count($json_recibido) }})
                </button>
            </div>
        @endif --}}
    </div>
</div>

<!-- OPCIONAL: Agregar un pequeño script para mejorar la UX -->
<script>
    document.addEventListener('livewire:initialized', () => {
        // Prevenir el parpadeo durante las selecciones
        Livewire.on('seleccionActualizada', () => {
            // Aquí puedes agregar efectos visuales suaves si es necesario
        });
    });
</script>
