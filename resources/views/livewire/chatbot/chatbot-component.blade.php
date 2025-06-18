<div>
    <!-- Botón flotante mejorado -->
    <button class="btn btn-primary position-fixed shadow-lg border-0" wire:click="toggleChat"
        style="bottom: 20px; right: 20px; width: 60px; height: 60px; border-radius: 50%; z-index: 1050; font-size: 24px; transition: all 0.2s ease;">
        @if ($open)
            ✖
        @else
            💬
        @endif
    </button>

    <!-- Ventana del chat mejorada -->
    @if ($open)
      <div style="position: fixed;bottom: 0px;right: 365px;"><img src="assets/media/avatars/robot1.png" alt=""></div>
        <div class="position-fixed shadow-lg border-0"
            style="bottom: 90px; right: 20px; width: 350px; z-index: 1051; border-radius: 15px; overflow: hidden; animation: slideUp 0.3s ease-out;">

            <div class="card border-0" style="border-radius: 15px;">
                <!-- Header mejorado -->
                <div class="card-header bg-primary text-white border-0 d-flex justify-content-between align-items-center"
                    style="padding: 15px 20px; background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;">
                    <div class="d-flex align-items-center">
                        <img src="assets/media/logos/custom-3-h25.png" alt="Logo" style="height: 25px;"
                            class="me-2">
                        <span class="fw-bold">Asistente Virtual</span>
                    </div>
                    <button class="btn btn-link text-white p-0 border-0" wire:click="toggleChat"
                        style="font-size: 18px; text-decoration: none; opacity: 0.8;">
                        ✖
                    </button>
                </div>

                <!-- Cuerpo del chat mejorado -->
                <div class="card-body p-0" style="height: 350px; background-color: #f8f9fa;">
                    <!-- Área de mensajes -->
                    <div class="h-100 overflow-auto p-3" style="scroll-behavior: smooth;"
                        id="chat-messages">
                        @if (empty($messages))
                            <div class="text-center text-muted py-4">
                                <div class="mb-3">
                                    <img src="assets/media/avatars/robot.png" alt="Robot"
                                        style="width: 50px; opacity: 0.7;">
                                </div>
                                <small>¡Hola! ¿En qué puedo ayudarte?</small>
                            </div>
                        @else
                            @foreach ($messages as $msg)
                                <div
                                    class="mb-3 d-flex {{ $msg['sender'] === 'user' ? 'justify-content-end' : 'justify-content-start' }}">
                                    @if ($msg['sender'] !== 'user')
                                        <div class="me-2">
                                            <img src="assets/media/avatars/robot.png" alt="Bot"
                                                style="width: 32px; height: 32px; border-radius: 50%;">
                                        </div>
                                    @endif

                                    <div class="d-flex flex-column {{ $msg['sender'] === 'user' ? 'align-items-end' : 'align-items-start' }}"
                                        style="max-width: 75%;">
                                        <div class="px-3 py-2 rounded-3 {{ $msg['sender'] === 'user' ? 'bg-primary text-white' : 'bg-white border' }}"
                                            style="word-wrap: break-word; {{ $msg['sender'] === 'user' ? 'border-radius: 18px 18px 5px 18px;' : 'border-radius: 18px 18px 18px 5px;' }}">

                                            @if($msg['sender'] === 'bot' && str_contains($msg['text'], '1️⃣'))
                                                <!-- Mostrar opciones como lista -->
                                                @php
                                                    $lines = explode("\n", $msg['text']);
                                                    $menuOptions = [];
                                                    $regularText = [];

                                                    foreach($lines as $line) {
                                                        $line = trim($line);
                                                        if(preg_match('/^[1-4]️⃣/', $line)) {
                                                            $menuOptions[] = $line;
                                                        } elseif(!empty($line)) {
                                                            $regularText[] = $line;
                                                        }
                                                    }
                                                @endphp

                                                @foreach($regularText as $text)
                                                    <div class="mb-2">{{ $text }}</div>
                                                @endforeach

                                                @if(count($menuOptions) > 0)
                                                    <div class="mt-2">
                                                        @foreach($menuOptions as $option)
                                                            <div class="p-2 mb-1 bg-light rounded border-start border-primary border-3 hover-option"
                                                                 style="cursor: pointer; transition: all 0.2s ease;"
                                                                 wire:click="selectOption('{{ substr($option, 0, 1) }}')">
                                                                {{ $option }}
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            @else
                                                {!! nl2br(e($msg['text'])) !!}
                                            @endif
                                        </div>
                                        <small class="text-muted mt-1" style="font-size: 0.75rem;">
                                            {{ $msg['sender'] === 'user' ? 'Tú' : 'Asistente' }}
                                        </small>
                                    </div>

                                    @if ($msg['sender'] === 'user')
                                        <div class="ms-2">
                                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                                                style="width: 32px; height: 32px; font-size: 14px;">
                                                U
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @endif

                        <!-- Ancla para scroll automático -->
                        <span id="scroll-anchor"></span>
                    </div>

                </div>

                <!-- Footer mejorado -->
                <div class="card-footer bg-white border-0" style="padding: 15px 20px;">
                    <form wire:submit.prevent="sendMessage">
                        <div class="input-group">
                            <input type="text" class="form-control border-0 bg-light" wire:model.defer="message"
                                placeholder="Escribe tu mensaje..."
                                style="border-radius: 25px 0 0 25px !important; padding: 12px 15px;" required>
                            <button class="btn btn-primary border-0" type="submit"
                                style="border-radius: 0 25px 25px 0 !important; padding: 12px 20px;">
                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path
                                        d="M15.854.146a.5.5 0 0 1 .11.54L13.026 8.5l2.938 7.814a.5.5 0 0 1-.11.54.5.5 0 0 1-.54.11L0 9.5l15.314-9.354a.5.5 0 0 1 .54.11z" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

</div>


<script>
document.addEventListener('livewire:updated', function () {
    // Scroll automático al último mensaje
    const chatMessages = document.getElementById('chat-messages');
    const scrollAnchor = document.getElementById('scroll-anchor');

    if (chatMessages && scrollAnchor) {
        // Usar setTimeout para asegurar que el DOM se actualice
        setTimeout(() => {
            scrollAnchor.scrollIntoView({
                behavior: 'smooth',
                block: 'end'
            });
        }, 100);
    }
});

// También hacer scroll cuando se abre el chat
document.addEventListener('livewire:load', function () {
    Livewire.hook('message.processed', (message, component) => {
        const chatMessages = document.getElementById('chat-messages');
        const scrollAnchor = document.getElementById('scroll-anchor');

        if (chatMessages && scrollAnchor) {
            setTimeout(() => {
                scrollAnchor.scrollIntoView({
                    behavior: 'smooth',
                    block: 'end'
                });
            }, 150);
        }
    });
});
</script>
