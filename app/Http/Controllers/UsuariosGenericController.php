<?php

namespace App\Http\Controllers;

use App\Models\Alumnos;
use App\Models\Docentes;
use App\Models\Usuarios;
use App\Models\UsuariosViewModel;
use Exception;
use DB;

class UsuariosGenericController
{
    //| funcion para retornar todos los registros de la tabla
    public function show()
    {
        //hacemos un select all de la vista
        $usuarios = UsuariosViewModel::all();

        //si usuarios está vacío
        if (empty($usuarios) || count($usuarios) <= 0) {
            //retorna una respuesta con detalles en caso de que no haya datos
            return response()->json(
                [
                    'status' => 200,
                    'message' => 'No se han encontrado registros',
                    'data' => []
                ],
                200
            );
        }

        //en caso de que si existan datos
        return response([
            'status' => 200,
            'message' => 'Registros encontrados exitosamente',
            'data' => $usuarios
        ], 200);
    }

    // | funcion para obtener informacion de un usuario
    public function getUser($id)
    {
        //buscamos si el usuario
        $user = DB::table('usuarios')
            ->join('roles', 'usuarios.id_rol', '=', 'roles.id')
            ->select('usuarios.id as id', 'roles.rol')
            ->where('usuarios.id', $id)->first();

        if (!$user) {
            //retorna una respuesta con detalles en caso de que no haya datos
            return response()->json(
                [
                    'status' => 404,
                    'message' => 'No se ha podido encontrar el usuario',
                    'data' => []
                ],
                404
            );
        }

        switch ($user->rol) {
            case 'Alumno':
                $usuario = DB::table('usuarios')
                    ->join('alumnos', 'usuarios.id', '=', 'alumnos.id_usuario')
                    ->select('usuarios.*', 'alumnos.*', 'usuarios.id as id', 'alumnos.id as id_alumno')
                    ->where('usuarios.id', $id)
                    ->first();

                // Quita la columna id_usuario de la tabla alumnos del resultado
                unset($usuario->id_usuario);

                break;
            case 'Docente':
                $usuario = DB::table('usuarios')
                    ->join('docentes', 'usuarios.id', '=', 'docentes.id_usuario')
                    ->select('usuarios.*', 'docentes.*', 'usuarios.id as id', 'docentes.id as id_alumno')
                    ->where('usuarios.id', $user->id)->first();

                // Quita la columna id_usuario de la tabla alumnos del resultado
                unset($usuario->id_usuario);
                break;
            default:
                $usuario = DB::table('usuarios')->where('id', $user->id)->first();
                break;
        }

        return response()->json(
            [
                'status' => 200,
                'message' => 'usuario encontrado',
                'data' => $usuario
            ],
            200
        );
    }

    // | funcion para obtener a los tutores
    public function getTutores()
    {
        //hacemos un select all de la vista
        $usuarios = UsuariosViewModel::where('rol', 'Tutor')->select('id', 'name')->get();

        //si usuarios está vacío
        if (empty($usuarios) || count($usuarios) <= 0) {
            //retorna una respuesta con detalles en caso de que no haya datos
            return response()->json(
                [
                    'status' => 200,
                    'message' => 'No se han encontrado registros',
                    'data' => []
                ],
                200
            );
        }

        //en caso de que si existan datos
        return response([
            'status' => 200,
            'message' => 'Registros encontrados exitosamente',
            'data' => $usuarios
        ], 200);
    }

    // | funcion para obtener a los docentes
    public function getDocentes()
    {
        //hacemos un select all de la vista
        // $usuarios = UsuariosViewModel::where('rol', 'Docente')->select('id', 'name')->get();
        $usuarios = DB::table('docentes as d')
        ->join('usuarios_info_view as u', 'd.id_usuario', '=', 'u.id')
        ->select('u.id', 'd.id as id_docente', 'u.name')
        ->get();


        //si usuarios está vacío
        if (empty($usuarios) || count($usuarios) <= 0) {
            //retorna una respuesta con detalles en caso de que no haya datos
            return response()->json(
                [
                    'status' => 200,
                    'message' => 'No se han encontrado registros',
                    'data' => []
                ],
                200
            );
        }

        //en caso de que si existan datos
        return response([
            'status' => 200,
            'message' => 'Registros encontrados exitosamente',
            'data' => $usuarios
        ], 200);
    }


    //| funcion para eliminar un usuario, recibe el id del usuario
    public function destroy($id)
    {
        $usuario = UsuariosViewModel::find($id);

        //si usuario no existe
        if (!$usuario) {
            //retorna una respuesta con detalles en caso de que no haya datos
            return response()->json(
                [
                    'status' => 404,
                    'message' => 'No se ha podido encontrar el usuario',
                    'data' => []
                ],
                404
            );
        }

        $exito = false;
        //intenta eliminar
        try {
            switch ($usuario['rol']) {
                case 'Docente':
                    $docente = Docentes::where('id_usuario', $id)->first();
                    if ($docente) {
                        $docente->delete();
                        Usuarios::find($id)->delete();
                        $exito = true;
                    }
                    break;
                case 'Alumno':
                    $alumno = Alumnos::where('id_usuario', $id)->first();
                    if ($alumno) {
                        $alumno->delete();
                        Usuarios::find($id)->delete();
                        $exito = true;
                    }
                    break;
                default:
                    Usuarios::find($id)->delete();
                    $exito = true;
                    break;
            }

            if ($exito) {
                return response()->json(
                    [
                        'status' => 200,
                        'message' => 'Se ha eliminado exitosamente el usuario de la base de datos',
                        'data' => []
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'status' => 500,
                        'message' => 'Se ha producido un error al intentar eliminar el usuario',
                        'data' => []
                    ],
                    500
                );
            }

        } catch (Exception $exception) {
            return response()->json(
                [
                    'status' => 500,
                    'message' => 'Se ha producido un error al intentar eliminar el usuario',
                    'data' => []
                ],
                500
            );
        }
    }
}
