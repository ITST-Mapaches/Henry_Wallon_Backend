<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use App\Models\UsuariosViewModel;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Models\USUARIOS_CREDENCIALES_VIEW;
use Illuminate\Support\Facades\Validator;

class AuthController
{
    //| funcion para logear usuario
    public function login(Request $request)
    {
        //valida campos requeridos para el login
        $validator = validator::make($request->all(), [
            'nombre_usuario' => 'required|string|max:40',
            'password' => 'required|string|max:200',
        ]);

        // si falla la validacion
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en validacion de campos',
                'status' => 400,
                'errors' => $validator->errors()->all()
            ], 400);
        }

        // intenta autenticar al usuario con las credenciales proporcionadas en la solicitud
        // verifica si los campos son validos en la DB, si no es asi, como esta negado
        // retorna una respuesta de error
        if (!Auth::attempt($request->only('nombre_usuario', 'password'))) {
            return response()->json([
                'status' => 401,
                'message' => 'Usuario y/o contraseña incorrectos!',
            ], 401);
        }

        //si se encontró, entonces obtiene la informacion relevante del user
        //en la vista UsuariosViewModel
        $user = UsuariosViewModel::where('username', $request->nombre_usuario)->first();

        if ($user->activo == 0) {
            return response()->json([
                'status' => 401,
                'message' => 'Tu cuenta esta inactiva, comunicate con tu administrador!'
            ], 401);
        }

        // obtiene al usuario de la tabla general Usuarios
        $usuario = Usuarios::where('nombre_usuario', $request->nombre_usuario)->first();

        $rol = DB::table('usuarios as u')
            ->join('usuarios_info_view as uiv', 'u.id', '=', 'uiv.id')
            ->select('uiv.rol as rol')
            ->where('u.id', $usuario->id)
            ->first();

        //retorna la respuesta
        return response()->json([
            'status' => 200,
            'message' => 'usuario logeado con exito',
            'id' => $user->id,
            'name' => $user->name,
            'username' => $user->username,
            'activo' => $user->activo,
            'rol' => $rol->rol,
            'token' => $usuario->createToken('API TOKEN')->plainTextToken
        ], 200);
    }

    // | funcion para cerrar sesion
    public function logout()
    {
        //elimina los tokens de usuario
        auth()->user()->tokens()->delete();

        //retorna una respuesta para confirmar el cierre de sesion
        return response([
            'status' => 200,
            'message' => 'sesión cerrada exitosamente'
        ], 200);
    }
}
