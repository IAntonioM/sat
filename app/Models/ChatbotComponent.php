<?php

namespace App\Livewire\Chatbot;

use Livewire\Component;
use App\Models\Chatbot;
use App\Models\ChatbotCategory;
use Illuminate\Support\Str;

class ChatbotComponent extends Component
{
    public $open = false;
    public $message = '';
    public $messages = [];
    public $showingMenu = true;
    public $sessionId;

    public function mount()
    {
        $this->sessionId = Str::uuid();
    }

    public function toggleChat()
    {
        $this->open = !$this->open;

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
            ]
        ];

        // Cargar menú desde la base de datos
        $menuOptions = Chatbot::getMainMenu();
        $menuText = $this->buildMenuText($menuOptions);

        $this->messages[] = [
            'sender' => 'bot',
            'text' => $menuText
        ];

        $this->showingMenu = true;
    }

    private function buildMenuText($menuOptions)
    {
        $menuText = "Selecciona una opción:\n\n";

        foreach ($menuOptions as $option) {
            $menuText .= "{$option->menu_number}️⃣ {$option->question}\n";
        }

        $menuText .= "\nTambién puedes escribir tu consulta directamente.";

        return $menuText;
    }

    public function sendMessage()
    {
        if (trim($this->message) === '') return;

        // Agregar mensaje del usuario
        $this->messages[] = ['sender' => 'user', 'text' => $this->message];

        // Procesar respuesta usando el modelo
        $response = $this->processMessage($this->message);
        $this->messages[] = ['sender' => 'bot', 'text' => $response];

        // Limpiar input
        $this->message = '';

        // Forzar actualización para el scroll
        $this->dispatch('messageAdded');
    }

    public function selectOption($option)
    {
        $this->message = $option;
        $this->sendMessage();
    }

    private function processMessage($message)
    {
        $userIp = request()->ip();
        $userAgent = request()->userAgent();

        // Usar el modelo para procesar el mensaje
        $result = Chatbot::processMessage($message, $this->sessionId, $userIp, $userAgent);

        if ($result && !empty($result)) {
            // Si encontramos una respuesta en la base de datos
            $response = is_array($result) ? $result[0] : $result;
            $this->showingMenu = false;
            return $response->response;
        }

        // Si no encontramos respuesta, usar lógica de fallback
        return $this->getFallbackResponse($message);
    }

    private function getFallbackResponse($message)
    {
        $message = strtolower(trim($message));

        // Verificar si es opción numérica del menú
        if (is_numeric($message)) {
            $menuResponses = Chatbot::getMenuResponse((int)$message);
            if (!empty($menuResponses)) {
                $this->showingMenu = false;
                return $menuResponses[0]->response;
            }
        }

        // Respuestas básicas de fallback
        if (str_contains($message, 'menú') || str_contains($message, 'opciones') || str_contains($message, 'ayuda')) {
            $this->showingMenu = true;
            $menuOptions = Chatbot::getMainMenu();
            return $this->buildMenuText($menuOptions);
        }

        // Respuesta por defecto
        $this->showingMenu = true;
        $menuOptions = Chatbot::getMainMenu();
        $menuText = $this->buildMenuText($menuOptions);

        return "🤖 No encontré una respuesta exacta a tu mensaje. Por favor selecciona una de estas opciones:\n\n" . $menuText;
    }

    public function render()
    {
        return view('livewire.chatbot.chatbot-component');
    }
}
