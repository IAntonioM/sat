<?php

namespace App\Livewire\Chatbot;

use Livewire\Component;

class ChatbotComponent extends Component
{
    public $open = false;
    public $message = '';
    public $messages = [];

    public function toggleChat()
    {
        $this->open = !$this->open;
    }

    public function sendMessage()
    {
        if (trim($this->message) === '') return;

        $this->messages[] = ['sender' => 'user', 'text' => $this->message];
        // Simulación de respuesta automática
        $this->messages[] = ['sender' => 'bot', 'text' => 'Hola, soy el chatbot. ¿En qué puedo ayudarte?'];

        $this->message = '';
    }

    public function render()
    {
        return view('livewire.chatbot.chatbot-component');
    }
}
