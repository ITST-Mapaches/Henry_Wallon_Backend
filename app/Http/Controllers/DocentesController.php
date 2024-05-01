<?php

namespace App\Http\Controllers;

use App\Models\Docentes;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use DB;


class DocentesController
{
    protected static ?string $password;

    // * funcion para validar informacion de los formularios
    private function validar(Request $request)
    {
        return validator::make($request->all(), [
            'nombre' => 'required|string|max:40',
            'ap_paterno' => 'required|string|max:40',
            'ap_materno' => 'required|string|max:40',
            'nacimiento' => 'required|date',
            'telefono' => 'required|string|max:12',
            'nombre_usuario' => 'required|string|max:40',
            'contrasena' => 'required|string|max:200',
            'activo' => 'required|boolean',
            'id_sexo' => 'required|int',
            'cedula_prof' => 'required|string|max:20'
        ]);
    }

    //| funcion para agregar un nuevo docente
    public function insert(Request $request)
    {
        // validando los datos recibidos
        $validator = $this->validar($request);

        //en caso de que la validacion falle
        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 400,
                    'message' => 'Ha habido un problema en la validacion de informacion',
                    'data' => []
                ],
                400
            );
        }

        //llamando al procedimiento para insertar un usuario
        $user = DB::select('CALL add_new_Docente(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $request->nombre,
            $request->ap_paterno,
            $request->ap_materno,
            $request->nacimiento,
            $request->telefono,
            $request->nombre_usuario,
            static::$password ??= Hash::make($request->contrasena),
            $request->activo,
            $request->id_sexo,
            $request->cedula_prof,
            Str::random(10)
        ]);

        //en caso de que no se haya insertado
        if (!$user || isset($user[0]->Level)) {
            return response()->json(
                [
                    'status' => 400,
                    'message' => 'No se ha podido insertar el usuario',
                    'data' => []
                ],
                400
            );
        }

        //en caso de que si existan datos
        return response([
            'status' => 200,
            'message' => 'Se ha insertado el usuario exitosamente',
            'data' => $user[0]
        ], 200);
    }

    //| funcion para actualizar un nuevo docente 
    public function update($id, Request $request)
    {
        //busca al usuario
        $user = Usuarios::find($id);

        //si el usuario no existe
        if (!$user) {
            return response()->json(
                [
                    'status' => 404,
                    'message' => 'No se ha podido encontrar el usuario',
                    'data' => []
                ],
                404
            );
        }

        // validando los datos recibidos
        $validator = $this->validar($request);

        //en caso de que la validacion falle
        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 400,
                    'message' => 'Ha habido un problema en la validacion de informacion',
                    'data' => []
                ],
                400
            );
        }

        //llamando al procedimiento para actualizar un usuario
        $user = DB::select('CALL update_Docente(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $id,
            $request->nombre,
            $request->ap_paterno,
            $request->ap_materno,
            $request->nacimiento,
            $request->telefono,
            $request->nombre_usuario,
            $request->contrasena,
            $request->activo,
            $request->id_sexo,
            $request->cedula_prof
        ]);

        //en caso de que no se haya actualizado
        if (!$user || isset($user[0]->Level)) {
            return response()->json(
                [
                    'status' => 400,
                    'message' => 'No se ha podido actualizar el usuario',
                    'data' => []
                ],
                400
            );
        }

        //en caso de que si existan datos
        return response([
            'status' => 200,
            'message' => 'Se ha actualizado el usuario exitosamente',
            'data' => $user[0]
        ], 200);
    }
}
