<?php

namespace App\Http\Controllers;

use App\Models\Grupos;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;

class GruposController
{
    //| funcion para retornar todos los registros
    public function show()
    {
        //hacemos un select all de la tabla
        $grupos = Grupos::all();

        //si grupos está vacío
        if (empty($grupos) || count($grupos) <= 0) {
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
            'data' => $grupos
        ], 200);
    }

    // funcion para validar la informacion recibida
    private function validar(Request $request)
    {
        return validator::make($request->all(), [
            'prefijo' => 'required|string|max:1',
        ]);
    }

    // |funcion para insertar un nuevo grupo
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

        // centralizando informacion del grupo
        $data = [
            'prefijo' => $request->prefijo,
        ];

        try {
            // inserta el grupo
            $grupo = Grupos::insert($data);

            return response([
                'status' => 200,
                'message' => 'Se ha insertado la grupo exitosamente',
                'data' => $grupo
            ], 200);

        } catch (Exception $ex) {
            return response()->json(
                [
                    'status' => 400,
                    'message' => 'No se ha podido insertar la grupo'
                ],
                400
            );
        }
    }

    // |funcion para actualizar un grupo
    public function update($id, Request $request)
    {
        // busca el grupo
        $grupo = Grupos::find($id);

        // si el grupo no existe
        if (!$grupo) {
            return response()->json(
                [
                    'status' => 404,
                    'message' => 'No se ha podido encontrar el grupo',
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

        // centralizando informacion del grupo
        $data = [
            'prefijo' => $request->prefijo,
        ];

        try {
            $grupo->update($data);

            return response([
                'status' => 200,
                'message' => 'Se ha actualizado el grupo exitosamente',
                'data' => $grupo['id'] . ': ' . $grupo['prefijo']
            ], 200);

        } catch (Exception $exception) {
            return response()->json(
                [
                    'status' => 400,
                    'message' => 'No se ha podido actualizar el grupo',
                    'data' => []
                ],
                400
            );
        }
    }

    // | funcion para eliminar un grupo
    public function destroy($id)
    {
        // busca el grupo
        $grupo = Grupos::find($id);

        // si la grupo no existe
        if (!$grupo) {
            return response()->json(
                [
                    'status' => 404,
                    'message' => 'No se ha podido encontrar el grupo',
                    'data' => []
                ],
                404
            );
        }

        $grupo->delete();

        $data = [
            'message' => 'grupo eliminada',
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}
