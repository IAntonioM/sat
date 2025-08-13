<div>
    <!-- Contenedor único para todo el componente -->
    <div>
        <!-- Botón flotante mejorado -->
        <button class="btn position-fixed shadow-lg border-0 d-flex align-items-center chatbot-btn" wire:click="toggleChat"
            style="bottom: 20px; right: 20px; height: 60px; border-radius: 30px; z-index: 1050; font-size: 16px; padding: 0 25px; min-width: 60px; 
                background: linear-gradient(135deg, #007bff 0%, #0056b3 50%, #28a745 100%);
                color: white; font-weight: 600; letter-spacing: 0.5px;
                animation: pulse 2s infinite, glow 3s ease-in-out infinite alternate;">
            <span style="font-size: 28px; margin-right: 10px; animation: bounce 2s infinite;">
                @if ($open)
                    ✖
                @else
                    🤖
                @endif
            </span>
            @if (!$open)
                <span class="chatbot-text" style="white-space: nowrap; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">
                    CHATBOT
                </span>
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

                                                @if ($msg['sender'] === 'bot' && isset($msg['loading']))
                                                    <!-- Indicador de carga -->
                                                    <div class="d-flex align-items-center">
                                                        <div class="spinner-border spinner-border-sm me-2" role="status" style="width: 1rem; height: 1rem;">
                                                            <span class="visually-hidden">Loading...</span>
                                                        </div>
                                                        <em class="text-muted">{{ $msg['text'] }}</em>
                                                    </div>
                                                @elseif($msg['sender'] === 'bot' && (str_contains($msg['text'], '️⃣') || str_contains($msg['text'], 'Selecciona')))
                                                    <!-- Mostrar opciones como lista -->
                                                    @php
                                                        $lines = explode("\n", $msg['text']);
                                                        $menuOptions = [];
                                                        $regularText = [];

                                                        foreach($lines as $line) {
                                                            $line = trim($line);
                                                            // Capturar todas las opciones numéricas
                                                            if(preg_match('/^(\d{1,2})️⃣/', $line)) {
                                                                $menuOptions[] = $line;
                                                            } elseif(!empty($line) && !str_contains($line, '️⃣')) {
                                                                // Solo agregar líneas que NO contengan emojis de números
                                                                $regularText[] = $line;
                                                            }
                                                        }
                                                    @endphp

                                                    <!-- Mostrar solo texto introductorio, no las opciones como texto -->
                                                    @foreach($regularText as $text)
                                                        @if(!preg_match('/^\d+️⃣/', $text))
                                                            <div class="mb-2">{{ $text }}</div>
                                                        @endif
                                                    @endforeach

                                                    <!-- Mostrar opciones como botones clicables -->
                                                    @if(count($menuOptions) > 0)
                                                        <div class="mt-2">
                                                            @foreach($menuOptions as $option)
                                                                @php
                                                                    // Extraer el número de la opción
                                                                    preg_match('/^(\d{1,2})️⃣/', $option, $matches);
                                                                    $optionNumber = $matches[1] ?? '';
                                                                @endphp
                                                                <div class="p-2 mb-1 bg-light rounded border-start border-primary border-3 hover-option"
                                                                    style="cursor: pointer; transition: all 0.2s ease; {{ $loading ? 'pointer-events: none; opacity: 0.5;' : '' }}"
                                                                    wire:click="selectOption('{{ $optionNumber }}')"
                                                                    onmouseover="this.style.backgroundColor='#e9ecef'"
                                                                    onmouseout="this.style.backgroundColor='#f8f9fa'">
                                                                    {{ $option }}
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                @else
                                                    {!! nl2br($msg['text']) !!}
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
                                <input type="text" class="form-control border-0 bg-light" wire:model.live="message"
                                    placeholder="Escribe tu mensaje..."
                                    style="border-radius: 25px 0 0 25px !important; padding: 12px 15px;"
                                    {{ $loading ? 'disabled' : '' }}
                                    required>
                                <button class="btn btn-primary border-0" type="submit"
                                    style="border-radius: 0 25px 25px 0 !important; padding: 12px 20px;"
                                    {{ $loading ? 'disabled' : '' }}>
                                    @if ($loading)
                                        <div class="spinner-border spinner-border-sm" role="status" style="width: 1rem; height: 1rem;">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    @else
                                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M15.854.146a.5.5 0 0 1 .11.54L13.026 8.5l2.938 7.814a.5.5 0 0 1-.11.54.5.5 0 0 1-.54.11L0 9.5l15.314-9.354a.5.5 0 0 1 .54.11z" />
                                        </svg>
                                    @endif
                                </button>
                            </div>
                        </form>

                        <!-- Indicador de estado de conexión -->
                        @if ($loading)
                            <div class="text-center mt-2">
                                <small class="text-muted">
                                    <span class="spinner-border spinner-border-sm me-1" role="status" style="width: 0.8rem; height: 0.8rem;"></span>
                                    Procesando mensaje...
                                </small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- CSS personalizado -->
        <style>
        @keyframes slideUp {
            from {
                transform: translateY(100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .hover-option:hover {
            background-color: #e9ecef !important;
            border-left-color: #0056b3 !important;
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }

        /* Scroll suave para el chat */
        #chat-messages {
            scrollbar-width: thin;
            scrollbar-color: #dee2e6 transparent;
        }

        #chat-messages::-webkit-scrollbar {
            width: 6px;
        }

        #chat-messages::-webkit-scrollbar-track {
            background: transparent;
        }

        #chat-messages::-webkit-scrollbar-thumb {
            background-color: #dee2e6;
            border-radius: 3px;
        }

        #chat-messages::-webkit-scrollbar-thumb:hover {
            background-color: #adb5bd;
        }
        
        .chatbot-btn {
            transform: scale(1);
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.4), 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .chatbot-btn:hover {
            transform: scale(1.1) translateY(-3px);
            box-shadow: 0 15px 35px rgba(0, 123, 255, 0.6), 0 8px 15px rgba(0, 0, 0, 0.3);
            background: linear-gradient(135deg, #0056b3 0%, #007bff 50%, #20c997 100%) !important;
        }

        .chatbot-btn:active {
            transform: scale(1.05) translateY(-1px);
        }

        /* Animaciones */
        @keyframes pulse {
            0% { box-shadow: 0 8px 25px rgba(0, 123, 255, 0.4), 0 4px 10px rgba(0, 0, 0, 0.2), 0 0 0 0 rgba(0, 123, 255, 0.7); }
            50% { box-shadow: 0 8px 25px rgba(0, 123, 255, 0.4), 0 4px 10px rgba(0, 0, 0, 0.2), 0 0 0 10px rgba(0, 123, 255, 0); }
            100% { box-shadow: 0 8px 25px rgba(0, 123, 255, 0.4), 0 4px 10px rgba(0, 0, 0, 0.2), 0 0 0 0 rgba(0, 123, 255, 0); }
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-8px); }
            60% { transform: translateY(-4px); }
        }

        @keyframes glow {
            from { filter: brightness(1) saturate(1); }
            to { filter: brightness(1.1) saturate(1.2); }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-2px); }
            75% { transform: translateX(2px); }
        }

        /* Punto de notificación */
        .notification-dot {
            position: absolute;
            top: -2px;
            right: -2px;
            width: 12px;
            height: 12px;
            background: linear-gradient(45deg, #ff4757, #ff6b7a);
            border-radius: 50%;
            border: 2px solid white;
            animation: shake 3s infinite;
            box-shadow: 0 2px 4px rgba(255, 71, 87, 0.4);
        }

        /* Texto del chatbot */
        .chatbot-text {
            opacity: 1;
            transform: translateX(0);
            transition: all 0.3s ease;
            font-size: 14px;
            letter-spacing: 1px;
        }

        .chatbot-btn:hover .chatbot-text {
            transform: translateX(3px);
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .chatbot-btn {
                min-width: 70px !important;
                width: 70px !important;
                height: 70px !important;
                border-radius: 50% !important;
                padding: 0 !important;
                font-size: 32px !important;
            }
            
            .chatbot-text {
                display: none !important;
            }
            
            .notification-dot {
                top: 2px;
                right: 2px;
                width: 16px;
                height: 16px;
            }
        }

        /* Animación de entrada cuando aparece */
        @keyframes slideIn {
            from {
                transform: translateX(100px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .chatbot-btn {
            animation: slideIn 0.6s ease-out, pulse 2s infinite 1s, glow 3s ease-in-out infinite alternate 2s;
        }
        </style>

        <script>
        document.addEventListener('livewire:initialized', function () {
            // Función para hacer scroll automático
            function scrollToBottom() {
                const chatMessages = document.getElementById('chat-messages');
                const scrollAnchor = document.getElementById('scroll-anchor');

                if (chatMessages && scrollAnchor) {
                    setTimeout(() => {
                        scrollAnchor.scrollIntoView({
                            behavior: 'smooth',
                            block: 'end'
                        });
                    }, 100);
                }
            }

            // Escuchar eventos de Livewire
            Livewire.on('messageAdded', () => {
                scrollToBottom();
            });

            // Scroll automático cuando se actualiza el componente
            document.addEventListener('livewire:updated', function () {
                scrollToBottom();
            });
        });

        // Compatibilidad con versiones anteriores de Livewire
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
    </div>
</div>