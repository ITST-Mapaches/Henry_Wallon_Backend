<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;



class UsuariosController
{
    protected static ?string $password;

    //| funcion para retornar todos los registros de la tabla
    // public function show()
    // {
    //     //hacemos un select all de la tabla
    //     $usuarios = Usuarios::all();

    //     //si usuarios está vacío
    //     if (empty($usuarios) || count($usuarios) <= 0) {
    //         //retorna una respuesta con detalles en caso de que no haya datos
    //         return response()->json(
    //             [
    //                 'status' => 200,
    //                 'message' => 'No se han encontrado registros',
    //                 'data' => []
    //             ],
    //             200
    //         );
    //     }

    //     //en caso de que si existan datos
    //     return response([
    //         'status' => 200,
    //         'message' => 'Registros encontrados exitosamente',
    //         'data' => $usuarios
    //     ], 200);
    // }

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
            'id_rol' => 'required|int',
        ]);
    }


    //| funcion para agregar un nuevo usuario
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

        $data = [
            'nombre' => $request->nombre,
            'ap_paterno' => $request->ap_paterno,
            'ap_materno' => $request->ap_materno,
            'nacimiento' => $request->nacimiento,
            'telefono' => $request->telefono,
            'nombre_usuario' => $request->nombre_usuario,
            'contrasena' => static::$password ??= Hash::make($request->contrasena),
            'activo' => $request->activo,
            'id_sexo' => $request->id_sexo,
            'id_rol' => $request->id_rol,
            'remember_token' => Str::random(10)
        ];

        $user = Usuarios::insert($data);

        //en caso de que no se haya insertado
        if (!$user) {
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
            'data' => $user
        ], 200);
    }

    //| funcion para acutualizar un usuario
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

        $data = [
            'nombre' => $request->nombre,
            'ap_paterno' => $request->ap_paterno,
            'ap_materno' => $request->ap_materno,
            'nacimiento' => $request->nacimiento,
            'telefono' => $request->telefono,
            'nombre_usuario' => $request->nombre_usuario,
            'contrasena' => static::$password ??= Hash::make($request->contrasena),
            'activo' => $request->activo,
            'id_sexo' => $request->id_sexo,
            'id_rol' => $request->id_rol,
            'remember_token' => Str::random(10)
        ];

        try {
            $user->update($data);

            return response([
                'status' => 200,
                'message' => 'Se ha actualizado el usuario exitosamente',
                'data' => $user['id'] . ': ' . $user['nombre']
            ], 200);
        } catch (Exception $exception) {
            return response()->json(
                [
                    'status' => 400,
                    'message' => 'No se ha podido actualizar el usuario',
                    'data' => []
                ],
                400
            );
        }

    }
}
