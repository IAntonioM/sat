namespace App\Http\Controllers;

use App\Models\Recibido;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RecibidoController extends Controller
{
    public function index(Request $request)
    {
        $data = Recibido::executeProcedure([
            'accion' => 2,
            'anio' => $request->input('anio'),
            'emitido_correlativo' => $request->input('emitido_correlativo'),
            'estado_recepcion_id' => $request->input('estado_recepcion_id'),
            'flag_favorito' => $request->input('flag_favorito'),
            'flag_marcador' => $request->input('flag_marcador'),
            'flag_archivado' => $request->input('flag_archivado'),
            'fecha_inicio' => $request->input('fecha_inicio'),
            'fecha_fin' => $request->input('fecha_fin'),
            'pagina' => $request->input('pagina', 1),
            'registros_por_pagina' => $request->input('registros_por_pagina', 10),
        ]);

        return response()->json([
            'data' => $data,
            'total' => count($data),
        ]);
    }

    public function show($correlativo)
    {
        $data = Recibido::executeProcedure([
            'accion' => 2,
            'correlativo' => $correlativo
        ]);

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $params = $request->all();
        $params['accion'] = 1;
        $params['fecha_recepcion'] = Carbon::now();

        $data = Recibido::executeProcedure($params);

        return response()->json($data);
    }

    public function updateEstado(Request $request, $correlativo)
    {
        $data = Recibido::executeProcedure([
            'accion' => 3,
            'correlativo' => $correlativo,
            'estado_recepcion_id' => $request->input('estado_recepcion_id')
        ]);

        return response()->json($data);
    }
}
