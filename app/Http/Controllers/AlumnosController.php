<?php

namespace App\Http\Controllers;

use App\Models\Alumnos;
use App\Models\Asignaturas;
use App\Models\Grupos;
use App\Models\Momentos;
use App\Models\PeriodosEscolares;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use DB;
use Exception;

class AlumnosController
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
            'num_control' => 'required|string|max:15',
            'id_usuario_tutor' => 'required|int',
            'id_periodo' => 'required|int',
            'id_grupo' => 'required|int',
        ]);
    }

    //| funcion para agregar un nuevo alumno
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

        try {
            //llamando al procedimiento para insertar un usuario
            $user = DB::select('CALL add_new_Student(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? , ? , ?, ?)', [
                $request->nombre,
                $request->ap_paterno,
                $request->ap_materno,
                $request->nacimiento,
                $request->telefono,
                $request->nombre_usuario,
                static::$password ??= Hash::make($request->contrasena),
                $request->activo,
                $request->id_sexo,
                $request->num_control,
                $request->id_usuario_tutor,
                $request->id_periodo,
                $request->id_grupo,
                Str::random(10)
            ]);

            // recuperando el id del alumno recien insertado
            $alumno = Alumnos::where('num_control', $request->num_control)->select('id')->first();

            // recuperando las materias que correspondan al mismo periodo del alumno recien insertado
            $asignaturas = Asignaturas::where('id_periodo', $request->id_periodo)->select('id')->get();

            // Iterando sobre las asignaturas para insertar los registros en la tabla 'momentos'
            foreach ($asignaturas as $asignatura) {
                Momentos::create([
                    'id_alumno' => $alumno->id,
                    'id_asignatura' => $asignatura->id,
                    'cal_primer_momento' => 0,
                    'cal_segundo_momento' => 0,
                    'cal_tercer_momento' => 0,
                ]);
            }

            return response()->json(
                [
                    'status' => 200,
                    'message' => 'Se ha insertado el alumno exitosamente',
                    'data' => $user[0]
                ],
                200
            );

        } catch (Exception $e) {

            return response()->json(
                [
                    'status' => 400,
                    'message' => 'Ha ocurrido un error al insertar el alumno',
                    'errors' => $e->getMessage()
                ],
                400
            );
        }
    }

    //| funcion para actualizar un alumno
    public function update($id, Request $request)
    {
        // Busca al usuario
        $user = Usuarios::find($id);

        // Si el usuario no existe
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

        // Validando los datos recibidos
        $validator = $this->validar($request);

        // En caso de que la validación falle
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

        $alumno = Alumnos::where('id_usuario', $user->id)->first();

        try {
            // Llamando al procedimiento para actualizar un usuario
            $usuario = DB::select('CALL update_Student(? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,?, ?)', [
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
                $request->num_control,
                $request->id_usuario_tutor,
                $request->id_periodo,
                $request->id_grupo,
            ]);

            if ($alumno->id_periodo != $request->id_periodo) {
                // Verificar si ya existen relaciones de asignaturas para el alumno en el nuevo periodo
                $existingMomentos = Momentos::where('id_alumno', $alumno->id)
                    ->whereIn('id_asignatura', function ($query) use ($request) {
                        $query->select('id')
                            ->from('asignaturas')
                            ->where('id_periodo', $request->id_periodo);
                    })
                    ->exists();

                // Si no existen relaciones, crearlas
                if (!$existingMomentos) {
                    $asignaturas = Asignaturas::where('id_periodo', $request->id_periodo)->select('id')->get();

                    foreach ($asignaturas as $asignatura) {
                        Momentos::create([
                            'id_alumno' => $alumno->id,
                            'id_asignatura' => $asignatura->id,
                            'cal_primer_momento' => 0,
                            'cal_segundo_momento' => 0,
                            'cal_tercer_momento' => 0,
                        ]);
                    }
                }
            }

            return response([
                'status' => 200,
                'message' => 'Se ha actualizado el usuario exitosamente',
                'data' => $usuario[0]
            ], 200);
        } catch (Exception $exc) {
            // En caso de que no se haya actualizado
            if (!$usuario || isset($usuario[0]->Level)) {
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


    public function getMomentosBySubjectGroupPeriod($id_asignatura, $num_period, $pref_grupo)
    {
        // buscamos las cosas
        $materia = Asignaturas::find($id_asignatura);
        $periodo = PeriodosEscolares::where('numero', $num_period)->first();
        $grupo = Grupos::where('prefijo', $pref_grupo)->first();

        if (!$materia || !$periodo || !$grupo) {
            return response([
                'status' => 404,
                'message' => "No se a encontrado informacion con la informacion recibida",
            ], 404);
        }

        $momentos = Momentos::select(
            'alumnos.num_control',
            DB::raw('CONCAT(usuarios.nombre, " ", usuarios.ap_paterno, " ", usuarios.ap_materno) as nombre'),
            'cal_primer_momento',
            'cal_segundo_momento',
            'cal_tercer_momento')
            ->join('alumnos', 'momentos.id_alumno', '=', 'alumnos.id')
            ->join('usuarios', 'alumnos.id_usuario', '=', 'usuarios.id')
            ->where('alumnos.id_grupo', $grupo->id)
            ->where('alumnos.id_periodo', $periodo->id)
            ->where('momentos.id_asignatura', $materia->id)
            ->get();

        return response([
            'status' => 200,
            'message' => 'Informacion encontrada con exito',
            'data' => $momentos
        ], 200);
    }
}
