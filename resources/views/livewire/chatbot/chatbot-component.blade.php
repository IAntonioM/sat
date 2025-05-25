<div>
    <!-- Botón flotante -->
    <button class="btn btn-primary position-fixed end-0 bottom-0 m-3 rounded-circle shadow"
        wire:click="toggleChat" style="z-index: 1050;">
        💬
    </button>

    <!-- Ventana del chat -->
    @if($open)
        <div class="position-fixed end-0 bottom-0 m-3 shadow" style="width: 300px; z-index: 1051;">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span>ChatBot</span>
                    <button class="btn btn-sm btn-light" wire:click="toggleChat">✖</button>
                </div>
                <div class="card-body" style="height: 300px; overflow-y: auto;">
                    @foreach($messages as $msg)
                        <div class="mb-2 text-{{ $msg['sender'] === 'user' ? 'end' : 'start' }}">
                            <span class="badge bg-{{ $msg['sender'] === 'user' ? 'primary' : 'secondary' }}">
                                {{ $msg['text'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
                <div class="card-footer">
                    <form wire:submit.prevent="sendMessage">
                        <div class="input-group">
                            <input type="text" class="form-control" wire:model.defer="message" placeholder="Escribe...">
                            <button class="btn btn-primary" type="submit">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
