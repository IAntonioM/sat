<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Chatbot extends Model
{
    protected $table = 'chatbot_responses';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'category_id',
        'question',
        'response',
        'response_type',
        'priority',
        'is_menu_option',
        'menu_number',
        'is_active'
    ];

    // Relación con categorías
    public function category()
    {
        return $this->belongsTo(ChatbotCategory::class, 'category_id');
    }

    // Relación con palabras clave
    public function keywords()
    {
        return $this->hasMany(ChatbotKeyword::class, 'response_id');
    }

    // Relación con conversaciones
    public function conversations()
    {
        return $this->hasMany(ChatbotConversation::class, 'response_id');
    }

    /**
     * Buscar respuesta por palabra clave
     */
    public static function findByKeyword($keyword)
    {
        return DB::select("
        SELECT r.*, c.name AS category_name
        FROM chatbot_responses r
        INNER JOIN chatbot_keywords k ON r.id = k.response_id
        LEFT JOIN chatbot_categories c ON r.category_id = c.id
        WHERE k.keyword LIKE ?
        AND r.is_active = 1
        ORDER BY r.priority DESC
    ", ["%{$keyword}%"]);
    }

    /**
     * Obtener menú principal
     */
    public static function getMainMenu()
    {
        return DB::select("
            SELECT r.*, c.name AS category_name
            FROM chatbot_responses r
            LEFT JOIN chatbot_categories c ON r.category_id = c.id
            WHERE r.is_menu_option = 1
            AND r.is_active = 1
            ORDER BY r.menu_number
        ");
    }

    /**
     * Buscar respuestas por múltiples palabras clave
     */
    public static function findByMultipleKeywords(array $keywords)
    {
        $placeholders = str_repeat('?,', count($keywords) - 1) . '?';

        return DB::select("
        SELECT
            r.*,
            c.name AS category_name,
            COUNT(k.id) AS keyword_matches,
            SUM(COALESCE(k.weight, 1)) AS total_weight
        FROM chatbot_responses r
        INNER JOIN chatbot_keywords k ON r.id = k.response_id
        LEFT JOIN chatbot_categories c ON r.category_id = c.id
        WHERE k.keyword IN ({$placeholders})
        AND r.is_active = 1
        GROUP BY r.id, r.category_id, r.question, r.response, r.response_type,
                 r.priority, r.is_menu_option, r.menu_number, r.is_active,
                 r.created_at, r.updated_at, c.name
        ORDER BY keyword_matches DESC, total_weight DESC, r.priority DESC
    ", $keywords);
    }

    /**
     * Procesar mensaje del usuario y obtener respuesta
     */
    public static function processMessage($message, $sessionId = null, $userIp = null, $userAgent = null)
    {
        $message = trim(strtolower($message));
        $response = null;

        // Verificar si es una opción numérica del menú
        if (is_numeric($message)) {
            $menuOption = (int)$message;
            $results = self::getMenuResponse($menuOption);
            if (!empty($results)) {
                $response = $results[0];
            }
        } else {
            // Primero intentar búsqueda exacta
            $exactResults = self::findByExactKeyword($message);
            if (!empty($exactResults)) {
                $response = $exactResults[0];
            } else {
                // Luego buscar por palabras clave múltiples
                $keywords = self::extractKeywords($message);
                if (!empty($keywords)) {
                    $results = self::findByMultipleKeywords($keywords);
                    if (!empty($results)) {
                        $response = $results[0];
                    }
                }
            }
        }

        // Registrar conversación
        if ($sessionId && $response) {
            self::saveConversation($sessionId, $message, $response, $userIp, $userAgent);
        }

        return $response;
    }

    /**
     * Obtener respuesta del menú por número
     */
    public static function getMenuResponse($menuNumber)
    {
        return DB::select("
            SELECT r.*, c.name AS category_name
            FROM chatbot_responses r
            LEFT JOIN chatbot_categories c ON r.category_id = c.id
            WHERE r.menu_number = ?
            AND r.is_menu_option = 1
            AND r.is_active = 1
        ", [$menuNumber]);
    }

    /**
     * Extraer palabras clave del mensaje
     */
    public static function extractKeywords($message)
    {
        // Obtener todas las keywords de la DB que coincidan
        $dbKeywords = DB::select("
        SELECT DISTINCT keyword
        FROM chatbot_keywords k
        INNER JOIN chatbot_responses r ON k.response_id = r.id
        WHERE r.is_active = 1
    ");

        $foundKeywords = [];
        $message = strtolower($message);

        foreach ($dbKeywords as $keywordObj) {
            $keyword = strtolower($keywordObj->keyword);
            if (str_contains($message, $keyword)) {
                $foundKeywords[] = $keyword;
            }
        }

        return $foundKeywords;
    }

    /**
     * Guardar conversación
     */
    public static function saveConversation($sessionId, $userMessage, $response, $userIp = null, $userAgent = null)
    {
        // Manejar correctamente el objeto response
        if (is_object($response)) {
            $responseText = $response->response;
            $responseId = $response->id;
        } elseif (is_array($response)) {
            $responseText = $response['response'];
            $responseId = $response['id'];
        } else {
            $responseText = $response;
            $responseId = null;
        }

        DB::insert("
        INSERT INTO chatbot_conversations (session_id, user_message, bot_response, response_id, user_ip, user_agent, created_at)
        VALUES (?, ?, ?, ?, ?, ?, GETDATE())
    ", [
            $sessionId,
            $userMessage,
            $responseText,
            $responseId,
            $userIp,
            $userAgent
        ]);
    }

    /**
     * Obtener estadísticas de conversaciones
     */
    public static function getConversationStats($startDate = null, $endDate = null)
    {
        $whereClause = "";
        $params = [];

        if ($startDate && $endDate) {
            $whereClause = "WHERE created_at BETWEEN ? AND ?";
            $params = [$startDate, $endDate];
        }

        return DB::select("
            SELECT
                COUNT(*) as total_conversations,
                COUNT(DISTINCT session_id) as unique_sessions,
                AVG(CAST(LEN(user_message) as FLOAT)) as avg_message_length
            FROM chatbot_conversations
            {$whereClause}
        ", $params);
    }

    /**
     * Obtener palabras clave más buscadas
     */
    public static function getTopKeywords($limit = 10)
    {
        return DB::select("
        SELECT
            k.keyword,
            COUNT(c.id) as usage_count,
            r.response
        FROM chatbot_keywords k
        INNER JOIN chatbot_responses r ON k.response_id = r.id
        LEFT JOIN chatbot_conversations c ON r.id = c.response_id
        WHERE r.is_active = 1
        GROUP BY k.keyword, r.response
        HAVING COUNT(c.id) > 0
        ORDER BY usage_count DESC
        LIMIT ?
    ", [$limit]);
    }

    public static function findByExactKeyword($keyword)
    {
        return DB::select("
        SELECT r.*, c.name AS category_name
        FROM chatbot_responses r
        INNER JOIN chatbot_keywords k ON r.id = k.response_id
        LEFT JOIN chatbot_categories c ON r.category_id = c.id
        WHERE k.keyword = ?
        AND r.is_active = 1
        ORDER BY r.priority DESC
    ", [$keyword]);
    }
}
