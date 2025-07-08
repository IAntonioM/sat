<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chatbot;
use App\Models\ChatbotCategory;
use App\Models\ChatbotKeyword;
use App\Models\ChatbotConversation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

/**
 * Controller principal del chatbot para la API
 */
class ChatbotController extends Controller
{
    /**
     * Procesar mensaje del chatbot
     */
    public function processMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:500',
            'session_id' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $message = $request->input('message');
            $sessionId = $request->input('session_id', Str::uuid());
            $userIp = $request->ip();
            $userAgent = $request->userAgent();

            // Procesar mensaje
            $result = Chatbot::processMessage($message, $sessionId, $userIp, $userAgent);

            if ($result && !empty($result)) {
                $response = is_array($result) ? $result[0] : $result;

                return response()->json([
                    'success' => true,
                    'data' => [
                        'response' => $response->response,
                        'response_type' => $response->response_type,
                        'category' => $response->category_name ?? null,
                        'session_id' => $sessionId
                    ]
                ]);
            }

            // Respuesta por defecto
            return response()->json([
                'success' => true,
                'data' => [
                    'response' => $this->getDefaultResponse(),
                    'response_type' => 'text',
                    'category' => 'general',
                    'session_id' => $sessionId
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error procesando el mensaje',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Obtener menú principal
     */
    public function getMainMenu()
    {
        try {
            $menuOptions = Chatbot::getMainMenu();

            return response()->json([
                'success' => true,
                'data' => $menuOptions
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error obteniendo el menú',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Buscar respuestas por palabra clave
     */
    public function searchByKeyword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'keyword' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $keyword = $request->input('keyword');
            $results = Chatbot::findByKeyword($keyword);

            return response()->json([
                'success' => true,
                'data' => $results
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error en la búsqueda',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Obtener conversaciones por sesión
     */
    public function getConversationHistory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'session_id' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $sessionId = $request->input('session_id');
            $conversations = ChatbotConversation::getBySession($sessionId);

            return response()->json([
                'success' => true,
                'data' => $conversations
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error obteniendo historial',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Obtener respuesta por defecto
     */
    private function getDefaultResponse()
    {
        return "🤖 No encontré una respuesta exacta a tu mensaje. Por favor selecciona una de estas opciones:\n\n" .
               "1️⃣ Consultas sobre tributos\n" .
               "2️⃣ Casilla electrónica\n" .
               "3️⃣ Buzón de notificaciones\n" .
               "4️⃣ Atención al cliente\n\n" .
               "O escribe tu duda nuevamente.";
    }
}

/**
 * Controller para administración del chatbot
 */
class ChatbotAdminController extends Controller
{
    /**
     * Mostrar dashboard con estadísticas
     */
    public function dashboard()
    {
        try {
            $stats = [
                'total_responses' => Chatbot::where('is_active', 1)->count(),
                'total_categories' => ChatbotCategory::where('is_active', 1)->count(),
                'total_keywords' => ChatbotKeyword::count(),
                'total_conversations' => ChatbotConversation::count(),
                'conversation_stats' => Chatbot::getConversationStats(),
                'top_keywords' => Chatbot::getTopKeywords(10)
            ];

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error obteniendo estadísticas',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Listar todas las respuestas
     */
    public function listResponses(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 15);
            $search = $request->input('search');

            $query = Chatbot::with('category', 'keywords');

            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('question', 'LIKE', "%{$search}%")
                      ->orWhere('response', 'LIKE', "%{$search}%");
                });
            }

            $responses = $query->orderBy('priority', 'desc')
                              ->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $responses
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error listando respuestas',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Crear nueva respuesta
     */
    public function createResponse(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'nullable|exists:chatbot_categories,id',
            'question' => 'nullable|string|max:500',
            'response' => 'required|string',
            'response_type' => 'required|in:text,menu,contact,link',
            'priority' => 'nullable|integer|min:1|max:10',
            'is_menu_option' => 'boolean',
            'menu_number' => 'nullable|integer|min:1|max:10',
            'keywords' => 'nullable|array',
            'keywords.*' => 'string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            // Crear respuesta
            $response = Chatbot::create([
                'category_id' => $request->input('category_id'),
                'question' => $request->input('question'),
                'response' => $request->input('response'),
                'response_type' => $request->input('response_type'),
                'priority' => $request->input('priority', 1),
                'is_menu_option' => $request->input('is_menu_option', false),
                'menu_number' => $request->input('menu_number'),
                'is_active' => true
            ]);

            // Agregar palabras clave si existen
            if ($request->has('keywords')) {
                foreach ($request->input('keywords') as $keyword) {
                    ChatbotKeyword::create([
                        'response_id' => $response->id,
                        'keyword' => strtolower(trim($keyword)),
                        'weight' => 1.0
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'data' => $response->load('category', 'keywords'),
                'message' => 'Respuesta creada exitosamente'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creando respuesta',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Actualizar respuesta existente
     */
    public function updateResponse(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'nullable|exists:chatbot_categories,id',
            'question' => 'nullable|string|max:500',
            'response' => 'required|string',
            'response_type' => 'required|in:text,menu,contact,link',
            'priority' => 'nullable|integer|min:1|max:10',
            'is_menu_option' => 'boolean',
            'menu_number' => 'nullable|integer|min:1|max:10',
            'is_active' => 'boolean',
            'keywords' => 'nullable|array',
            'keywords.*' => 'string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $response = Chatbot::findOrFail($id);

            // Actualizar respuesta
            $response->update([
                'category_id' => $request->input('category_id'),
                'question' => $request->input('question'),
                'response' => $request->input('response'),
                'response_type' => $request->input('response_type'),
                'priority' => $request->input('priority', $response->priority),
                'is_menu_option' => $request->input('is_menu_option', $response->is_menu_option),
                'menu_number' => $request->input('menu_number'),
                'is_active' => $request->input('is_active', $response->is_active)
            ]);

            // Actualizar palabras clave si se proporcionan
            if ($request->has('keywords')) {
                // Eliminar keywords existentes
                ChatbotKeyword::where('response_id', $response->id)->delete();

                // Agregar nuevas keywords
                foreach ($request->input('keywords') as $keyword) {
                    ChatbotKeyword::create([
                        'response_id' => $response->id,
                        'keyword' => strtolower(trim($keyword)),
                        'weight' => 1.0
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'data' => $response->load('category', 'keywords'),
                'message' => 'Respuesta actualizada exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error actualizando respuesta',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Eliminar respuesta
     */
    public function deleteResponse($id)
    {
        try {
            $response = Chatbot::findOrFail($id);
            $response->delete();

            return response()->json([
                'success' => true,
                'message' => 'Respuesta eliminada exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error eliminando respuesta',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Obtener estadísticas de conversaciones
     */
    public function getConversationStats(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $stats = Chatbot::getConversationStats($startDate, $endDate);
            $topKeywords = Chatbot::getTopKeywords(20);
            $recentConversations = ChatbotConversation::getRecent(50);

            return response()->json([
                'success' => true,
                'data' => [
                    'stats' => $stats,
                    'top_keywords' => $topKeywords,
                    'recent_conversations' => $recentConversations
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error obteniendo estadísticas',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Exportar conversaciones
     */
    public function exportConversations(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $conversations = ChatbotConversation::query()
                ->when($startDate && $endDate, function($query) use ($startDate, $endDate) {
                    return $query->whereBetween('created_at', [$startDate, $endDate]);
                })
                ->with('response')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $conversations,
                'total' => $conversations->count()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error exportando conversaciones',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}

/**
 * Controller para gestión de categorías
 */
class ChatbotCategoryController extends Controller
{
    /**
     * Listar todas las categorías
     */
    public function index()
    {
        try {
            $categories = ChatbotCategory::getActiveCategories();

            return response()->json([
                'success' => true,
                'data' => $categories
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error obteniendo categorías',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Crear nueva categoría
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:chatbot_categories,name',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $category = ChatbotCategory::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'icon' => $request->input('icon'),
                'sort_order' => $request->input('sort_order', 0),
                'is_active' => true
            ]);

            return response()->json([
                'success' => true,
                'data' => $category,
                'message' => 'Categoría creada exitosamente'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creando categoría',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Actualizar categoría
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:chatbot_categories,name,' . $id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $category = ChatbotCategory::findOrFail($id);
            $category->update($request->all());

            return response()->json([
                'success' => true,
                'data' => $category,
                'message' => 'Categoría actualizada exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error actualizando categoría',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Eliminar categoría
     */
    public function destroy($id)
    {
        try {
            $category = ChatbotCategory::findOrFail($id);
            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Categoría eliminada exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error eliminando categoría',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
