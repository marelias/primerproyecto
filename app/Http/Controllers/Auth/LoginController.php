<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class LoginController extends Controller
{
    /*
    |----------------------------------------------------------------------
    | Login Controller
    |----------------------------------------------------------------------
    |
    | Este controlador maneja la autenticación de usuarios para la aplicación
    | y los redirige a la pantalla de inicio según el rol del usuario.
    |
    */

    use AuthenticatesUsers;

    /**
     * Crear una nueva instancia del controlador.
     *
     * @return void
     */
    public function __construct()
    {
        // Los usuarios deben estar autenticados para poder cerrar sesión
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Redirige a los usuarios después de iniciar sesión según su rol.
     *
     * @return string
     */
    protected function redirectPath()
    {
        // Si el usuario tiene el rol 'admin', redirige a la ruta de admin
        if (Auth::user()->hasRole('admin')) {
            return "/admin/ruta";
        }

        // Si el usuario tiene el rol 'empresa', redirige a la ruta de empresa
        if (Auth::user()->hasRole('empresa')) {
            return "/admin/empresa";
        }

        // Si no tiene los roles anteriores, redirige al usuario al home
        return "/";
    }
}


