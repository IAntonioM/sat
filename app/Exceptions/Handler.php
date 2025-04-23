<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Session\TokenMismatchException;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {


        // Error 404
        if ($exception instanceof NotFoundHttpException) {
            return redirect()->route('principal')->with([
                'alert' => [
                    'type' => 'warning', // SweetAlert usa 'error' en lugar de 'danger'
                    'title' => 'Página no encontrada',
                    'message' => 'La página que estás buscando no existe.'
                ]
            ]);
        }

        // Error 419 (token expirado)
        if ($exception instanceof TokenMismatchException) {
            // Silenciosamente recargar a la misma ruta
            return redirect()->back();
        }


        return parent::render($request, $exception);
    }
}
