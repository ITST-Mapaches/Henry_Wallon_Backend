<?php

namespace App\Http\Controllers;

use App\Models\Momentos;
use Illuminate\Http\Request;

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
}
