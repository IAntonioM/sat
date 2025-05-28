<?php

namespace App\Livewire\Chatbot;

use Livewire\Component;

class ChatbotComponent extends Component
{
    public $open = false;
    public $message = '';
    public $messages = [];
    public $showingMenu = true;

    public function mount()
    {
        // No inicializar mensajes aquí para que sea más rápido
    }

    public function toggleChat()
    {
        $this->open = !$this->open;

        // Solo inicializar cuando se abre el chat por primera vez
        if ($this->open && empty($this->messages)) {
            $this->initializeChat();
        }
    }

    private function initializeChat()
    {
        $this->messages = [
            [
                'sender' => 'bot',
                'text' => '👋 ¡Hola! Bienvenido al asistente virtual del SAT (Servicio de Administración Tributaria). ¿En qué podemos ayudarte hoy?'
            ],
            [
                'sender' => 'bot',
                'text' => "Selecciona una opción:\n\n1️⃣ Consultas sobre tributos\n2️⃣ Casilla electrónica\n3️⃣ Buzón de notificaciones\n4️⃣ Atención al cliente\n\nTambién puedes escribir tu consulta directamente."
            ]
        ];
        $this->showingMenu = true;
    }

    public function sendMessage()
    {
        if (trim($this->message) === '') return;

        // Agregar mensaje del usuario
        $this->messages[] = ['sender' => 'user', 'text' => $this->message];

        // Procesar respuesta del bot
        $response = $this->processMessage($this->message);
        $this->messages[] = ['sender' => 'bot', 'text' => $response];

        // Limpiar input
        $this->message = '';

        // Forzar actualización para el scroll
        $this->dispatch('messageAdded');
    }

    // Nuevo método para seleccionar opciones directamente
    public function selectOption($option)
    {
        $this->message = $option;
        $this->sendMessage();
    }

    private function processMessage($message)
    {
        $message = trim($message);

        if (is_numeric($message)) {
            $option = (int)$message;
            return $this->getMenuResponse($option);
        }

        return $this->getTextResponse($message);
    }

    private function getMenuResponse($option)
    {
        $this->showingMenu = false;

        switch ($option) {
            case 1:
                return "💼 **Consultas sobre tributos:**\n\n• Impuesto a la Renta, IGV, ITAN\n• Declaraciones y pagos mensuales\n• Cronogramas de vencimiento\n\n¿Sobre qué tributo deseas consultar?";

            case 2:
                return "📬 **Casilla electrónica:**\n\n• Revisa notificaciones oficiales\n• Accede con tu N.Documento y clave \n• Guarda tus comunicaciones del SAT\n\n¿Necesitas ayuda para acceder a tu casilla?";

            case 3:
                return "📨 **Buzón de notificaciones:**\n\n• Consulta notificaciones pendientes\n• Configura alertas por correo\n• Visualiza documentos tributarios\n\n¿Deseas saber cómo usarlo?";

            case 4:
                return "📞 **Atención al cliente:**\n\n• Teléfono: (01) 315-0730\n• WhatsApp: +51 987 654 321\n• Email: consultas@sat.gob.pe\n\n¿Prefieres que te llamemos o escribamos?";

            default:
                $this->showingMenu = true;
                return "❌ Opción no válida. Por favor selecciona una opción del menú:\n\n1️⃣ Consultas sobre tributos\n2️⃣ Casilla electrónica\n3️⃣ Buzón de notificaciones\n4️⃣ Atención al cliente\n\nO escribe tu consulta directamente.";
        }
    }

    private function getTextResponse($message)
    {
        $message = strtolower($message);

        // Respuestas para palabras clave relacionadas con menú
        if (str_contains($message, 'menú') || str_contains($message, 'opciones') || str_contains($message, 'ayuda')) {
            $this->showingMenu = true;
            return "Aquí tienes las opciones disponibles:\n\n1️⃣ Consultas sobre tributos\n2️⃣ Casilla electrónica\n3️⃣ Buzón de notificaciones\n4️⃣ Atención al cliente\n\nSelecciona una opción o escribe tu consulta directamente.";
        }

        if (str_contains($message, 'hola') || str_contains($message, 'buenos')) {
            return "👋 ¡Hola! ¿En qué puedo ayudarte? Usa el menú o escribe tu consulta relacionada al SAT.";
        }

        if (str_contains($message, 'tributo') || str_contains($message, 'pago') || str_contains($message, 'declaración')) {
            return "💰 Puedes realizar tus pagos y declaraciones a través de nuestra plataforma online. ¿Qué tributo deseas declarar o pagar?";
        }

        if (str_contains($message, 'casilla') || str_contains($message, 'clave sol')) {
            return "🔐 Para ingresar a tu casilla electrónica, usa tu Num Documento y Clave . ¿Olvidaste tu clave o tienes problemas de acceso?";
        }

        if (str_contains($message, 'notificación') || str_contains($message, 'buzón')) {
            return "📨 Tu buzón de notificaciones contiene documentos oficiales del SAT. Puedes revisarlos accediendo con tu clave.";
        }

        if (str_contains($message, 'atención') || str_contains($message, 'contacto') || str_contains($message, 'teléfono')) {
            return "📞 Nuestro equipo de atención al cliente está disponible de Lunes a Viernes de 8:30 a.m. a 5:30 p.m. al (01) 111-111 WhatsApp +51 999 999 999.";
        }

        if (str_contains($message, 'gracias') || str_contains($message, 'thank')) {
            return "😊 ¡De nada! Si tienes otra consulta, estaré encantado de ayudarte.";
        }

        if (str_contains($message, 'adiós') || str_contains($message, 'bye') || str_contains($message, 'chau')) {
            return "👋 ¡Hasta pronto! Recuerda que puedes contactarnos 24/7 mediante este chat.";
        }

        // Respuesta por defecto con menú
        $this->showingMenu = true;
        return "🤖 No encontré una respuesta exacta a tu mensaje. Por favor selecciona una de estas opciones:\n\n1️⃣ Consultas sobre tributos\n2️⃣ Casilla electrónica\n3️⃣ Buzón de notificaciones\n4️⃣ Atención al cliente\n\nO escribe tu duda nuevamente.";
    }

    public function render()
    {
        return view('livewire.chatbot.chatbot-component');
    }
}
