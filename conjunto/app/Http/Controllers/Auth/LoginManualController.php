<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginManualController extends Controller
{
    public function login(Request $request)
    {
        $usuario = DB::table('usuarios')
            ->where('cedula', $request->cedula)
            ->where('clave', $request->password)
            ->first();

        if ($usuario) {
            session(['usuario' => $usuario]);
            // Redirige según el tipo de usuario
            switch (strtoupper($usuario->tipo_usuario)) {
                case 'ADMINISTRADOR':
                    return redirect()->route('dashboard.admin');
                case 'CAJERO':
                    return redirect()->route('dashboard.cajero');
                case 'CLIENTE':
                    return redirect()->route('dashboard.cliente');
                default:
                    return redirect()->route('index');
            }
        } else {
            return back()->with('error', 'Credenciales incorrectas');
        }
    }
}
