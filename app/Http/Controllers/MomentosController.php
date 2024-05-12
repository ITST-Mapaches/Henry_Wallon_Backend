<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Alumnos;
use App\Models\Momentos;

class MomentosController
{
    //| funcion para retornar todos los registros
    public function show()
    {
        //hacemos un select all de la tabla
        $Momentos = Momentos::all();

        //si Momentos está vacío
        if (empty($Momentos) || count($Momentos) <= 0) {
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
            'data' => $Momentos
        ], 200);
    }

    //| funcion para validar la informacion recibida
    private function validar(Request $request)
    {
        return validator::make($request->all(), [
            'cal_primer_momento' => 'required|int|min:0|max:10',
            'cal_segundo_momento' => 'required|int|min:0|max:10',
            'cal_tercer_momento' => 'required|int|min:0|max:10',
        ]);
    }

    // funcion para actualizar momentos de un alumno con su asignatura
    public function updateMomentos($num_control, $id_asignatura, Request $request)
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

        //obtiene
        $alumno = Alumnos::where('num_control', $num_control)->select('id')->first();

        if (!$alumno) {
            return response([
                'status' => 404,
                'message' => 'Error, no se ha encontrado un registro que concuerde con el alumno indicado',
                'data' => []
            ], 404);
        }

        // obtiene
        $momentoRegistro = Momentos::where('id_alumno', $alumno['id'])
            ->where('id_asignatura', $id_asignatura)->first();

        if (!$momentoRegistro) {
            return response([
                'status' => 404,
                'message' => 'Error, no se ha encontrado un registro que concuerde con la asignatura indicada',
                'data' =>[]
            ], 404);
        }


        $data = [
            'id_alumno' => $alumno['id'],
            'id_asignatura' => $id_asignatura,
            'cal_primer_momento' => $request->cal_primer_momento,
            'cal_segundo_momento' => $request->cal_segundo_momento,
            'cal_tercer_momento' => $request->cal_tercer_momento,
        ];

        $momentoRegistro->update($data);

        return response([
            'status' => 200,
            'message' => 'Informacion de calificaciones actualizada exitosamente',
            'data' => []
        ], 200);
    }
}
