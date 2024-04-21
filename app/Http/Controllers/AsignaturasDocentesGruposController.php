<?php

namespace App\Http\Controllers;

use App\Models\AsignaturasDocentesGrupos;
use Illuminate\Http\Request;

class AsignaturasDocentesGruposController
{
    //| funcion para retornar todos los registros de la tabla
    public function show()
    {
        //hacemos un select all de la tabla
        $data = AsignaturasDocentesGrupos::all();

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
}
