<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeudaConsolidadaController extends Controller
{
    /**
     * Mostrar la vista de deudas consolidadas (ahora con Livewire)
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Verificar que hay una sesión válida
        $codigoContribuyente = session('codigo_contribuyente') ??
                              session('cod_usuario') ?? null;

        if (!$codigoContribuyente) {
            return redirect()->route('login')->with([
                'alert' => [
                    'type' => 'error',
                    'title' => 'Sesión inválida',
                    'message' => 'No se encontró el código de contribuyente en la sesión'
                ]
            ]);
        }

        // La lógica ahora está en el componente Livewire
        return view('consolidado');
    }

    /**
     * Método de compatibilidad para el filtro (redirige al index)
     * Se mantiene por compatibilidad con rutas existentes
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function filtrar(Request $request)
    {
        // Los filtros ahora se manejan en tiempo real con Livewire
        return redirect()->route('consolidado')->with('message', 'Use los filtros en la página');
    }

    /**
     * Endpoint para pagos via AJAX (opcional, para compatibilidad)
     * La funcionalidad principal está en el componente Livewire
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function pagar(Request $request)
    {
        // Este método se mantiene solo para compatibilidad con llamadas AJAX externas
        // La funcionalidad principal está ahora en el componente Livewire

        return response()->json([
            'status' => 'info',
            'message' => 'Use la funcionalidad de pago integrada en la página'
        ]);
    }
}
