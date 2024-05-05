<?php

namespace App\Http\Controllers;

use App\Models\AsignaturasDocentesGrupos;
use App\Models\Docentes;
use Illuminate\Http\Request;

class AsignaturasDocentesGruposController
{
    //| funcion para retornar todos los registros de la tabla
    public function show($id_asignatura)
    {
        //hacemos un select all de la tabla
        $data = AsignaturasDocentesGrupos::where('id_asignatura', $id_asignatura)->get();

        //si data está vacío
        if (empty($data) || count($data) <= 0) {
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
            'data' => $data
        ], 200);
    }


    // | metodo para insertar 
    public function insert(Request $request)
    {

        $idMateria = $request->input('id_materia');
        $data = $request->except('id_materia');

        try {
            foreach ($data as $idGrupo => $idUsuario) {
                // Obtener el id del docente en base al id_usuario
                $idDocente = Docentes::where('id_usuario', $idUsuario)->value('id');

                AsignaturasDocentesGrupos::create([
                    'id_asignatura' => $idMateria,
                    'id_docente' => $idDocente,
                    'id_grupo' => $idGrupo
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Se han insertado los registros exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error al insertar los registros',
                'error' => $e->getMessage()
            ], 500);
        }

    }



    // | metodo para actualizar relaciones
    public function update(Request $request)
    {
        $idMateria = $request->input('id_materia');
        $datos = $request->except('id_materia');

        try {
            foreach ($datos as $idGrupo => $idDocente) {
                // Verificar si existe un registro para esta asignatura, docente y grupo
                $existeRegistro = AsignaturasDocentesGrupos::where('id_asignatura', $idMateria)
                    ->where('id_grupo', $idGrupo)
                    ->exists();

                if ($existeRegistro) {
                    // Actualizar el registro existente
                    AsignaturasDocentesGrupos::where('id_asignatura', $idMateria)
                        ->where('id_grupo', $idGrupo)
                        ->update(['id_docente' => $idDocente]);
                } else {
                    // Insertar un nuevo registro
                    AsignaturasDocentesGrupos::create([
                        'id_asignatura' => $idMateria,
                        'id_docente' => $idDocente,
                        'id_grupo' => $idGrupo
                    ]);
                }
            }

            return response()->json([
                'status' => 200,
                'message' => 'Se han actualizado los registros exitosamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error al actualizar los registros',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
