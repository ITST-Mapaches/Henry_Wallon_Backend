<?php

namespace App\Http\Controllers;

use App\Models\Asignaturas;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;

class AsignaturasController
{
    //| funcion para retornar todos los registros
    public function show()
    {
        //hacemos un select all de la tabla
        $asignaturas = Asignaturas::all();

        //si asignaturas está vacío
        if (empty($asignaturas) || count($asignaturas) <= 0) {
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
            'data' => $asignaturas
        ], 200);
    }



    // funcion para validar la informacion recibida
    private function validar(Request $request)
    {
        return validator::make($request->all(), [
            'clave' => 'required|string|max:10',
            'nombre' => 'required|string|max:50',
            'objetivo' => 'required|string|max:64000',
            'id_periodo' => 'required|int',
            'calificacion_aprobatoria' => 'required|int'
        ]);
    }

    // | funcion para insertar una nueva asignatura
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

        // centralizando informacion de usuario
        $data = [
            'clave' => $request->clave,
            'nombre' => $request->nombre,
            'objetivo' => $request->objetivo,
            'id_periodo' => $request->id_periodo,
            'calificacion_aprobatoria' => $request->calificacion_aprobatoria,
        ];

        try {
            // inserta la asignatura y recuperando el id
            $id_asignatura = Asignaturas::insertGetId($data);

            // obtiene el nombre de la asignatura recién insertada
            $nombreAsignatura = Asignaturas::where('id', $id_asignatura)->value('nombre');

            return response([
                'status' => 200,
                'message' => 'Se ha insertado la asignatura exitosamente',
                'data' => [
                    'id' => $id_asignatura,
                    'nombre' => $nombreAsignatura
                ]
            ], 200);

        } catch (Exception $ex) {
            return response()->json(
                [
                    'status' => 400,
                    'message' => 'No se ha podido insertar la asignatura',
                    'data' => []
                ],
                400
            );
        }
    }

    public function getAsignatura($id)
    {
        // busca la asignatura
        $asignatura = Asignaturas::find($id);

        // si la asignatura no existe
        if (!$asignatura) {
            return response()->json(
                [
                    'status' => 404,
                    'message' => 'No se ha podido encontrar la asignatura',
                    'data' => []
                ],
                404
            );
        }

        return response([
            'status' => 200,
            'message' => 'Asignatura encontrada',
            'data' => $asignatura
        ], 200);
    }

    //| funcion para actualizar una asignatura
    public function update($id, Request $request)
    {
        // busca la asignatura
        $asignatura = Asignaturas::find($id);

        // si la asignatura no existe
        if (!$asignatura) {
            return response()->json(
                [
                    'status' => 404,
                    'message' => 'No se ha podido encontrar la asignatura',
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

        // centralizando informacion de usuario
        $data = [
            'clave' => $request->clave,
            'nombre' => $request->nombre,
            'objetivo' => $request->objetivo,
            'id_periodo' => $request->id_periodo,
            'calificacion_aprobatoria' => $request->calificacion_aprobatoria,
        ];

        try {
            $asignatura->update($data);

            return response([
                'status' => 200,
                'message' => 'Se ha actualizado el usuario exitosamente',
                'data' => $asignatura['id'] . ': ' . $asignatura['nombre']
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

    // funcion para eliminar una asignatura
    public function destroy($id)
    {
        // busca la asignatura
        $asignatura = Asignaturas::find($id);

        // si la asignatura no existe
        if (!$asignatura) {
            return response()->json(
                [
                    'status' => 404,
                    'message' => 'No se ha podido encontrar la asignatura',
                    'data' => []
                ],
                404
            );
        }

        $asignatura->delete();

        $data = [
            'message' => 'asignatura eliminada',
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}
