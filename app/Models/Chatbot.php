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
            ORDER BY CAST(r.menu_number AS INT) ASC
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
            // 1. Búsqueda exacta
            $exactResults = self::findByExactKeyword($message);
            if (!empty($exactResults)) {
                $response = $exactResults[0];
            } else {
                // 2. Búsqueda por múltiples keywords
                $keywords = self::extractKeywords($message);
                if (!empty($keywords)) {
                    $results = self::findByMultipleKeywords($keywords);
                    if (!empty($results)) {
                        $response = $results[0];
                    }
                } else {
                    // 3. Búsqueda flexible por palabras clave
                    $flexibleResult = self::findByFlexibleKeywords($message);
                    if ($flexibleResult) {
                        $response = $flexibleResult;
                    } else {
                        // 4. Búsqueda por similitud
                        $similarityResult = self::findBySimilarity($message);
                        if ($similarityResult) {
                            $response = $similarityResult;
                        }
                    }
                }
            }
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

    /**
     * Buscar por similitud usando distancia de Levenshtein
     */
    public static function findBySimilarity($message, $threshold = 0.6)
    {
        $keywords = DB::select("
        SELECT k.*, r.*, c.name AS category_name
        FROM chatbot_keywords k
        INNER JOIN chatbot_responses r ON k.response_id = r.id
        LEFT JOIN chatbot_categories c ON r.category_id = c.id
        WHERE r.is_active = 1
    ");

        $matches = [];
        $message = strtolower(trim($message));

        foreach ($keywords as $keyword) {
            $keywordText = strtolower($keyword->keyword);

            // Calcular similitud
            $similarity = self::calculateSimilarity($message, $keywordText);

            // También buscar en sinónimos si existen
            if (!empty($keyword->synonyms)) {
                $synonyms = explode(',', $keyword->synonyms);
                foreach ($synonyms as $synonym) {
                    $synonymSimilarity = self::calculateSimilarity($message, strtolower(trim($synonym)));
                    $similarity = max($similarity, $synonymSimilarity);
                }
            }

            // Buscar palabras parciales
            if (str_contains($message, $keywordText) || str_contains($keywordText, $message)) {
                $similarity = max($similarity, 0.8);
            }

            if ($similarity >= $threshold) {
                $matches[] = [
                    'response' => $keyword,
                    'similarity' => $similarity,
                    'weight' => $keyword->weight ?? 1
                ];
            }
        }

        // Ordenar por similitud y peso
        usort($matches, function ($a, $b) {
            if ($a['similarity'] == $b['similarity']) {
                return $b['weight'] <=> $a['weight'];
            }
            return $b['similarity'] <=> $a['similarity'];
        });

        return !empty($matches) ? $matches[0]['response'] : null;
    }

    /**
     * Calcular similitud entre dos textos
     */
    private static function calculateSimilarity($text1, $text2)
    {
        $longer = strlen($text1) > strlen($text2) ? $text1 : $text2;
        $shorter = strlen($text1) > strlen($text2) ? $text2 : $text1;

        if (strlen($longer) == 0) return 1.0;

        $distance = levenshtein($shorter, $longer);
        return (strlen($longer) - $distance) / strlen($longer);
    }

    /**
     * Buscar por palabras clave flexibles
     */
    public static function findByFlexibleKeywords($message)
    {
        $message = strtolower(trim($message));
        $words = explode(' ', $message);

        // Buscar respuestas que contengan alguna de las palabras del mensaje
        $likeConditions = [];
        $params = [];

        foreach ($words as $word) {
            if (strlen($word) > 2) { // Solo palabras de más de 2 caracteres
                $likeConditions[] = "k.keyword LIKE ? OR k.synonyms LIKE ?";
                $params[] = "%{$word}%";
                $params[] = "%{$word}%";
            }
        }

        if (empty($likeConditions)) return null;

        $whereClause = implode(' OR ', $likeConditions);

        $results = DB::select("
        SELECT TOP 1
            r.*,
            c.name AS category_name,
            COUNT(k.id) AS keyword_matches,
            SUM(COALESCE(k.weight, 1)) AS total_weight
        FROM chatbot_responses r
        INNER JOIN chatbot_keywords k ON r.id = k.response_id
        LEFT JOIN chatbot_categories c ON r.category_id = c.id
        WHERE ({$whereClause})
        AND r.is_active = 1
        GROUP BY r.id, r.category_id, r.question, r.response, r.response_type,
                 r.priority, r.is_menu_option, r.menu_number, r.is_active,
                 r.created_at, r.updated_at, c.name
        ORDER BY keyword_matches DESC, total_weight DESC, r.priority DESC
    ", $params);

        return !empty($results) ? $results[0] : null;
    }
}
