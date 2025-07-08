<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para ChatbotCategory
 */
class ChatbotCategory extends Model
{
    protected $table = 'chatbot_categories';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
        'icon',
        'sort_order',
        'is_active'
    ];

    // Relación con respuestas
    public function responses()
    {
        return $this->hasMany(Chatbot::class, 'category_id');
    }

    // Obtener categorías activas ordenadas
    public static function getActiveCategories()
    {
        return self::where('is_active', 1)
            ->orderBy('sort_order')
            ->get();
    }
}

/**
 * Modelo para ChatbotKeyword
 */
class ChatbotKeyword extends Model
{
    protected $table = 'chatbot_keywords';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'response_id',
        'keyword',
        'weight'
    ];

    // Relación con respuesta
    public function response()
    {
        return $this->belongsTo(Chatbot::class, 'response_id');
    }

    // Buscar palabras clave por texto
    public static function findKeywordsByText($text)
    {
        return self::where('keyword', 'LIKE', "%{$text}%")
            ->with('response')
            ->get();
    }
}

/**
 * Modelo para ChatbotConversation
 */
class ChatbotConversation extends Model
{
    protected $table = 'chatbot_conversations';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'session_id',
        'user_message',
        'bot_response',
        'response_id',
        'user_ip',
        'user_agent'
    ];

    protected $dates = ['created_at'];

    // Relación con respuesta
    public function response()
    {
        return $this->belongsTo(Chatbot::class, 'response_id');
    }

    // Obtener conversaciones por sesión
    public static function getBySession($sessionId)
    {
        return self::where('session_id', $sessionId)
            ->orderBy('created_at')
            ->get();
    }

    // Obtener conversaciones recientes
    public static function getRecent($limit = 50)
    {
        return self::orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
