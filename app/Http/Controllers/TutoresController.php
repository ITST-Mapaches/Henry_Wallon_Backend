<?php

namespace App\Http\Controllers;

use App\Models\Tutores;
use Illuminate\Http\Request;

class TutoresController
{

    //| funcion para retornar todos los registros
    public function show()
    {
        //hacemos un select all de la tabla
        $tutores = Tutores::all();

        //si tutores está vacío
        if (empty($tutores) || count($tutores) <= 0) {
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
            'data' => $tutores
        ], 200);
    }
}
