<?php

namespace App\Livewire\Chatbot;

use App\Models\Chatbot;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class ChatbotComponent extends Component
{
    public $open = false;
    public $message = '';
    public $messages = [];
    public $showingMenu = true;
    public $sessionId;
    public $loading = false;
    public $initialized = false; // ✅ Nuevo flag para evitar duplicación

    public function mount()
    {
        $this->sessionId = session()->getId();
    }

    public function toggleChat()
    {
        $this->open = !$this->open;

        // Solo inicializar cuando se abre el chat por primera vez Y no está inicializado
        if ($this->open && !$this->initialized) {
            $this->initializeChat();
            $this->initialized = true; // ✅ Marcar como inicializado
        }
    }

    private function initializeChat()
    {
        // Obtener el menú principal desde la base de datos
        $menuOptions = Chatbot::getMainMenu();

        $this->messages = [
            [
                'sender' => 'bot',
                'text' => '👋 ¡Hola! Bienvenido al asistente virtual del SAT (Servicio de Administración Tributaria). ¿En qué podemos ayudarte hoy?'
            ]
        ];

        // Construir el mensaje del menú desde la base de datos
        $menuText = "Selecciona una opción:\n\n";
        foreach ($menuOptions as $option) {
            $menuText .= "{$option->menu_number}️⃣ {$option->question}\n";
        }
        $menuText .= "\nTambién puedes escribir tu consulta directamente.";

        $this->messages[] = [
            'sender' => 'bot',
            'text' => $menuText
        ];

        $this->showingMenu = true;
    }

    public function sendMessage()
    {
        if (trim($this->message) === '') return;

        // Agregar mensaje del usuario
        $this->messages[] = ['sender' => 'user', 'text' => $this->message];

        // Mostrar indicador de carga
        $this->loading = true;
        $this->messages[] = ['sender' => 'bot', 'text' => 'Escribiendo...', 'loading' => true];

        // Procesar respuesta del bot
        $response = $this->processMessage($this->message);

        // Remover mensaje de carga y agregar respuesta real
        array_pop($this->messages);
        $this->messages[] = ['sender' => 'bot', 'text' => $response];

        // Limpiar input
        $this->message = '';
        $this->loading = false;

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
        $this->loading = true;

        try {
            $dbResponse = Chatbot::processMessage($message, $this->sessionId, request()->ip(), request()->userAgent());

            if ($dbResponse) {
                $this->showingMenu = str_contains($dbResponse->response, '1️⃣');
                $responseWithPdfs = $this->addPdfLinksToResponse($dbResponse->response, $dbResponse->id ?? null);
                return $responseWithPdfs;
            }

            // Fallback final
            return $this->getFallbackResponse();
        } catch (\Exception $e) {
            // En caso de error, usar la base de datos
            $dbResponse = Chatbot::processMessage($message, $this->sessionId, request()->ip(), request()->userAgent());

            if ($dbResponse) {
                return $this->addPdfLinksToResponse($dbResponse->response, $dbResponse->id ?? null);
            }

            return $this->getFallbackResponse();
        } finally {
            $this->loading = false;
        }
    }

    private function getFallbackResponse()
    {
        $this->showingMenu = true;
        $menuOptions = Chatbot::getMainMenu();

        $menuText = "🤖 No encontré una respuesta exacta. Selecciona una opción:\n\n";
        foreach ($menuOptions as $option) {
            $menuText .= "{$option->menu_number}️⃣ {$option->question}\n";
        }
        $menuText .= "\nO escribe tu duda nuevamente.";

        return $menuText;
    }

    private function addPdfLinksToResponse($response, $responseId = null)
    {
        // Buscar menciones de FUT y FIC-01 y agregar enlaces
        $response = preg_replace(
            '/\bFUT\b/',
            '<a href="' . route('chatbot.pdf', ['type' => 'fut', 'response_id' => $responseId]) . '" target="_blank" class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-file-pdf"></i> FUT</a>',
            $response
        );
        
        $response = preg_replace(
            '/\bFicha FIC-01\b/',
            '<a href="' . route('chatbot.pdf', ['type' => 'fic01']) . '" target="_blank" class="btn btn-sm btn-outline-success me-1"><i class="fas fa-file-pdf"></i> Ficha FIC-01</a>',
            $response
        );
        
        return $response;
    }

    private function getMenuResponse($option)
    {
        $this->showingMenu = false;

        $menuResponse = Chatbot::getMenuResponse($option);

        if (!empty($menuResponse)) {
            return $menuResponse[0]->response;
        }

        // Fallback si no se encuentra la opción
        $this->showingMenu = true;
        return "❌ Opción no válida. Por favor selecciona una opción del menú válida o escribe tu consulta directamente.";
    }

    private function getTextResponse($message)
    {
        $response = Chatbot::processMessage($message, $this->sessionId, request()->ip(), request()->userAgent());

        if ($response) {
            // Si la respuesta contiene opciones de menú, activar el flag
            $this->showingMenu = str_contains($response->response, '1️⃣');
            return $response->response;
        }

        // Si no se encuentra respuesta, mostrar menú
        $this->showingMenu = true;
        return "🤖 No encontré una respuesta exacta a tu mensaje. Por favor selecciona una de estas opciones o escribe tu duda nuevamente.";
    }

    public function render()
    {
        return view('livewire.chatbot.chatbot-component');
    }
}