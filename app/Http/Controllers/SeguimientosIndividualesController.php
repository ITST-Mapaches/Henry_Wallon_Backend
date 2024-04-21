<?php

namespace App\Http\Controllers;

use App\Models\SeguimientosIndividuales;
use Illuminate\Http\Request;

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
}
