<?php

namespace App\Http\Controllers;

use App\Models\Alumnos;
use App\Models\Asignaturas;
use App\Models\Docentes;
use App\Models\SeguimientosIndividuales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class SeguimientosIndividualesController
{

    //| funcion para retornar todos los registros
    public function show()
    {
        //hacemos un select all de la tabla
        $seguimientos = SeguimientosIndividuales::all();

        //si seguimientos está vacío
        if (empty($seguimientos) || count($seguimientos) <= 0) {
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
            'data' => $seguimientos
        ], 200);
    }

    // | funcion para obtener el seguimiento de un estudiante por su ID
    public function getSeguimientoByStudentControl($num_control, $id_asignatura)
    {
        // buscamos la primer coindicencia de un alumno cuyo numero de control corresponda al indicado
        $alumno = Alumnos::where('num_control', $num_control)->first();

        // si no existe el alumno
        if (!$alumno) {
            return response()->json([
                'message' => 'No se ha encontrado al estudiante con el numero de control dado',
                'status' => 404,
                'data' => []
            ], 404);
        }

        // buscamos la materia por su id
        $asignatura = Asignaturas::find($id_asignatura);

        // si no existe la asignatura
        if (!$asignatura) {
            return response()->json([
                'message' => 'No se ha encontrado la asignatura indicada',
                'status' => 404,
                'data' => []
            ], 404);
        }

        // buscamos el seguimiento
        $seguimiento = SeguimientosIndividuales::where('id_alumno', $alumno->id)->where('id_asignatura', $asignatura->id)->first();

        // si no existe el seguimiento
        if (!$seguimiento) {
            return response()->json([
                'message' => 'No hay seguimientos para el alumno ' . $alumno->num_control . ' en la materia ' . $asignatura->nombre,
                'status' => 200,
                'data' => []
            ], 200);
        }

        // retorna el seguimiento encontrado, lo retorno en array para evitar conflicto en frontend
        return response([
            'status' => 200,
            'message' => 'busqueda de informacion exitosa',
            'data' => [$seguimiento]
        ], 200);
    }

    //| funcion para validar datos de frontend
    private function validar(Request $request)
    {
        return validator::make($request->all(), [
            'descripcion' => 'required|string|max:64000',
        ]);
    }

    // | crear un seguimiento
    public function insert($num_control, $id_asignatura, $id_user, Request $request)
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

        // buscamos la primer coindicencia de un alumno cuyo numero de control corresponda al indicado
        $alumno = Alumnos::where('num_control', $num_control)->first();

        // si no existe el alumno
        if (!$alumno) {
            return response()->json([
                'message' => 'No se ha encontrado al estudiante con el numero de control dado',
                'status' => 404,
                'data' => []
            ], 404);
        }

        // buscamos la materia por su id
        $asignatura = Asignaturas::find($id_asignatura);

        // si no existe la asignatura
        if (!$asignatura) {
            return response()->json([
                'message' => 'No se ha encontrado la asignatura indicada',
                'status' => 404,
                'data' => []
            ], 404);
        }

        // buscamos el docente
        $docente = Docentes::where('id_usuario', $id_user)->first();

        // si no existe el docente
        if (!$docente) {
            return response()->json([
                'message' => 'No se ha encontrado el docente indicado',
                'status' => 404,
                'data' => []
            ], 404);
        }

        // centramos informacion
        $data = [
            'id_alumno' => $alumno->id,
            'id_asignatura' => $asignatura->id,
            'id_docente' => $docente->id,
            'descripcion' => $request->descripcion,
        ];

        // inserta en la base de datos
        $seguimiento = SeguimientosIndividuales::insert($data);

        // si no existe el seguimiento / no se inserto
        if (!$seguimiento) {
            return response()->json(
                [
                    'status' => 400,
                    'message' => 'No se ha podido insertar el seguimiento',
                    'data' => []
                ],
                400
            );
        }

        return response([
            'status' => 200,
            'message' => 'Se ha creado el seguimiento exitosamente',
            'data' => $seguimiento
        ], 200);
    }

    //| funcion para actualizar seguimiento individual
    public function update($seguimiento_id, Request $request)
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

        // buscamos el seguimiento
        $seguimiento = SeguimientosIndividuales::find($seguimiento_id);

        // si no existe el seguimiento
        if (!$seguimiento) {
            return response()->json(
                [
                    'status' => 400,
                    'message' => 'No se ha podido encontrar el seguimiento',
                    'data' => []
                ],
                400
            );
        }

        // centramos informacion de la solicitud
        $data = [
            'descripcion' => $request->descripcion
        ];

        // actualizamos
        $seguimiento->update($data);

        // respuesta de exito
        return response()->json([
            'status' => 200,
            'message' => 'Se ha actualizado el seguimiento exitosamente',
            'data' => $seguimiento
        ], 200);
    }


    // | funcion para eliminar un seguimiento
    public function destroy($id)
    {
        // buscamos el seguimiento
        $seguimiento = SeguimientosIndividuales::find($id);

        // si no existe el seguimiento
        if (!$seguimiento) {
            return response()->json(
                [
                    'status' => 400,
                    'message' => 'No se ha podido encontrar el seguimiento',
                    'data' => []
                ],
                400
            );
        }

        // eliminamos el seguimiento
        $seguimiento->delete();

        // respuesta de exito
        return response()->json([
            'status' => 200,
            'message' => 'Se ha eliminado el seguimiento exitosamente',
            'data' => []
        ], 200);
    }

    // | funcion para obtener los sqguimientos individuales de alumnos
    // | tutorados de un tutor
    public function getSeguimientos($id_tutor)
    {
        // establece el query
        $query = "
                SELECT
                u.id AS id_usuario,
                a.id AS id_alumno,
                CONCAT(u.nombre, ' ', u.ap_paterno, ' ', u.ap_materno) as nombre_alumno,
                COALESCE(JSON_ARRAYAGG(JSON_OBJECT('asignatura', asig.nombre, 'detalle', si.descripcion)), '[]') AS seguimientos
            FROM
                usuarios u
                    JOIN alumnos a ON u.id = a.id_usuario
                    LEFT JOIN seguimientos_individuales si ON a.id = si.id_alumno
                    LEFT JOIN asignaturas asig ON si.id_asignatura = asig.id
            WHERE
                a.id_usuario_tutor = ?
            GROUP BY
                u.id, a.id, nombre_alumno;";

        // realiza el query
        $seguimientos = DB::select($query, [$id_tutor]);

        // respuesta de exito
        return response()->json([
            'status' => 200,
            'message' => 'Se han encontrado los seguimientos exitosamente',
            'data' => $seguimientos
        ], 200);
    }
}
