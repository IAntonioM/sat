<?php

namespace App\Http\Controllers\Home;

use App\Services\ServicioEmail;
use App\Http\Controllers\Controller;
use App\Models\SolicitudAcceso;
use App\Models\Contribuyente;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;

class PendientesController extends Controller
{
    public function index(Request $request)
    {
        // Obtener el código del contribuyente de la sesión o del parámetro
        $codigoContribuyente = session('codigo_contribuyente') ??
            session('cod_usuario') ?? null; // Valor por defecto para pruebas

        $usuario = Contribuyente::obtenerDatosContri($codigoContribuyente);

        if (!$codigoContribuyente) {
            // Si no hay código de contribuyente, redirigir al login
            return redirect()->route('login')->with([
                'alert' => [
                    'type' => 'error',
                    'title' => 'Sesión inválida',
                    'message' => 'No se encontró el código de contribuyente en la sesión'
                ]
            ]);
        }

        // Obtener datos del contribuyente
        $contribuyente = SolicitudAcceso::obtenerDatosContribuyente($codigoContribuyente);

        if (!$contribuyente) {
            return redirect()->route('login')->with('error', 'No se encontró el contribuyente');
        }

        // Obtener los filtros
        $estadoSeleccionado  = $request->estadoSeleccionado ?? '%';

        // Obtener las usuarios detalladas
        $usuarios = SolicitudAcceso::obtenerSolicitudes($estadoSeleccionado);

        // Preparar datos para la vista
        $estados = SolicitudAcceso::obtenerEstadosDisponibles();
        $fechaActual = Carbon::now()->format('d/m/Y');

        $viewData = [
            'contribuyente' => $contribuyente,
            'Pendientes' => $usuarios,
            'estadosDisponibles' => $estados,
            'estadoSeleccionado' => $estadoSeleccionado,
            'fechaActual' => $fechaActual,
            'usuario' => $usuario
        ];

        Debugbar::info('Datos:', $viewData);

        return view('pendientes', $viewData);
    }

    public function AceptarSolicitud(Request $request)
    {
        $iCodPreTramite = $request->iCodPreTramite;
        $solicitud = SolicitudAcceso::where('iCodPreTramite', $iCodPreTramite)->first();

        $codigoContribuyente = session('codigo_contribuyente') ?? session('cod_usuario') ?? null;
        $usuario = Contribuyente::obtenerDatosContri($codigoContribuyente);
        $vusuario = $usuario->vusuario;

        $dni = $solicitud->nNumDocuId;


        $nFlgEstado = $request->nFlgEstado;
        $estacionActualizacion = gethostname();
        $PasswordHash = Hash::make($dni);

        // Aceptar o denegar la solicitud
        SolicitudAcceso::aceptarDenegarSolicitud($iCodPreTramite, $nFlgEstado, $vusuario, $estacionActualizacion, $PasswordHash);

        // Obtener datos de la solicitud para mandar el correo


        $nuevoUSuarioDAtos = SolicitudAcceso::traerUsuarioNuevo($solicitud->nNumDocuId);

        Debugbar::info('data:',$solicitud,'NuevosUsuairo', $nuevoUSuarioDAtos,'vusuaroi', $vusuario,'usuario', $usuario);

        if ($solicitud && $solicitud->correoDestino && $nuevoUSuarioDAtos) {
            // Enviar correo
            $servicioEmail = new ServicioEmail();
            $correoDestino = $solicitud->correoDestino;
            $asunto = 'Solicitud de Acceso Aceptada';
            $contenido = '<p>Estimado usuario,</p>
                <p>Su solicitud de acceso con el asunto <strong>' . $solicitud->cAsunto . '</strong> ha sido aceptada.</p>
                <p><strong>Credenciales del usuario:</strong><br>
                Nombre de usuario: ' . $nuevoUSuarioDAtos->vnrodoc . '<br>
                Contraseña de usuario: ' . $nuevoUSuarioDAtos->vnrodoc . '</p>
                <p>Gracias por confiar en nosotros.</p>';

            $servicioEmail->enviar($correoDestino, $asunto, $contenido);
        }



        return redirect()->route('Pendiente')->with('success', 'Solicitud aceptada correctamente');
    }



    public function DenegarSolicitud(Request $request)
    {
        $codigoContribuyente = session('codigo_contribuyente') ??
            session('cod_usuario') ?? null;
        $usuario = Contribuyente::obtenerDatosContri($codigoContribuyente);
        $vusuario = $usuario->vusuario;

        //Datos que se trae desde el view
        $iCodPreTramite = $request->iCodPreTramite;
        $nFlgEstado = $request->nFlgEstado;

        //Dato para la estacion
        $estacionActualizacion = gethostname();

        SolicitudAcceso::aceptarDenegarSolicitud($iCodPreTramite, $nFlgEstado, $vusuario, $estacionActualizacion, '%');

        return redirect()->route('Pendiente')->with('success', 'Solicitud denegada correctamente');
    }
}
