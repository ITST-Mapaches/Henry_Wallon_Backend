<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DB;

class checkRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        //obtiene la informacion del usuario que tiene sesion iniciada actualmente
        $user = $request->user();

        //obtiene el rol del usuario actual
        $rol = DB::table('usuarios as u')
        ->join('usuarios_info_view as uiv', 'u.id', '=', 'uiv.id')
        ->select('uiv.rol as rol')
        ->where('u.id', $user->id)
        ->first();

        // valida si no existe el usuario o si no contiene el rol pasado aquí
        if (!$user || !in_array($rol->rol, $roles)) {
            return response([
                'message' => 'tu rol actual, no esta autorizado para ver esto',
                'status' => 403,
                'usuario' => $user,
                'rol' => $rol->rol
            ], 403);
        }

        return $next($request);
    }
}
