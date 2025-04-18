<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Lang;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'usuario' => 'required',
            'password' => 'required',
        ];
    }

    protected $maxAttempts = 3; // máximo de intentos

    protected $decaySeconds = 300; // tiempo de espera en segundos (5 minutos)


    public function ensureIsNotRateLimited()
    {
        $key = $this->throttleKey();

        if (!RateLimiter::tooManyAttempts($key, $this->maxAttempts)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($key);

        throw ValidationException::withMessages([
            'password' => [
                Lang::get("Demasiados intentos. Por favor intenta de nuevo en ".ceil($seconds / 60)." minuto(s).")
            ],
        ]);
    }
    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'usuario.required' => 'El campo usuario es obligatorio.',
            'password.required' => 'El campo contraseña es obligatorio.',
        ];
    }

    public function throttleKey()
    {
        return Str::lower($this->input('usuario')).'|'.$this->ip();
    }

    public function incrementLoginAttempts()
    {
        RateLimiter::hit($this->throttleKey(), $this->decaySeconds); // 120 segundos
    }

    public function clearLoginAttempts()
    {
        RateLimiter::clear($this->throttleKey());
    }
}
