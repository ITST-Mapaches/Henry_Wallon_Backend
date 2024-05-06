<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\PeriodosEscolares;
use Illuminate\Http\Request;
use Exception;

class PeriodosEscolaresController
{
    //| funcion para retornar todos los registros
    public function show()
    {
        //hacemos un select all de la tabla
        $periodos = PeriodosEscolares::all();

        //si periodos está vacío
        if (empty($periodos) || count($periodos) <= 0) {
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
            'data' => $periodos
        ], 200);
    }

    // | funcion para obtener un periodo
    public function getPeriodo($id)
    {
        // busca el periodo
        $periodo = PeriodosEscolares::find($id);

        // si el periodo no existe
        if (!$periodo) {
            return response()->json(
                [
                    'status' => 404,
                    'message' => 'No se ha podido encontrar el periodo',
                    'data' => []
                ],
                404
            );
        }

        // retorna el periodo
        return response([
            'status' => 200,
            'message' => 'Periodo encontrado con exito',
            'data' => $periodo
        ], 200);
    }

    //| funcion para validar la informacion recibida
    private function validar(Request $request)
    {
        return validator::make($request->all(), [
            'numero' => 'required|int',
            'nombre_tipo' => 'required|string|max:20',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
        ]);
    }

    //| funcion para agregar un nuevo periodo
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
            'numero' => $request->numero,
            'nombre_tipo' => $request->nombre_tipo,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ];

        $periodo = PeriodosEscolares::insert($data);

        //en caso de que no se haya insertado
        if (!$periodo) {
            return response()->json(
                [
                    'status' => 400,
                    'message' => 'No se ha podido insertar el periodo',
                    'data' => []
                ],
                400
            );
        }

        //en caso de que si existan datos
        return response([
            'status' => 200,
            'message' => 'Se ha insertado el periodo exitosamente',
            'data' => $periodo
        ], 200);
    }

    //| funcion para actualizar un periodo
    public function update($id, Request $request)
    {
        // busca el periodo
        $periodo = PeriodosEscolares::find($id);

        // si el periodo no existe
        if (!$periodo) {
            return response()->json(
                [
                    'status' => 404,
                    'message' => 'No se ha podido encontrar el periodo',
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
            'numero' => $request->numero,
            'nombre_tipo' => $request->nombre_tipo,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ];

        try {
            $periodo->update($data);

            return response([
                'status' => 200,
                'message' => 'Se ha actualizado el periodo exitosamente',
                'data' => $periodo['id'] . ': ' . $periodo['nombre_tipo']
            ], 200);

        } catch (Exception $exception) {
            return response()->json(
                [
                    'status' => 400,
                    'message' => 'No se ha podido actualizar el periodo',
                    'data' => []
                ],
                400
            );
        }
    }

    //| funcion para eliminar un periodo escolar
    public function destroy($id)
    {
        // busca el periodo
        $periodo = PeriodosEscolares::find($id);

        // si el periodo no existe
        if (!$periodo) {
            return response()->json(
                [
                    'status' => 404,
                    'message' => 'No se ha podido encontrar el periodo',
                    'data' => []
                ],
                404
            );
        }

        // elimina el periodo
        $periodo->delete();

        // retorna respuesta
        return response()->json([
            'message' => 'periodo escolar eliminado',
            'status' => 200
        ], 200);
    }
}
