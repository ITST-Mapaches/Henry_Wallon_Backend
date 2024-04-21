<?php

namespace App\Http\Controllers;

use App\Models\Sexos;
use Illuminate\Http\Request;

class SexosController
{
    //| funcion para retornar todos los registros
    public function show()
    {
        //hacemos un select all de la tabla
        $sexos = Sexos::all();

        //si sexos está vacío
        if (empty($sexos) || count($sexos) <= 0) {
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
            'data' => $sexos
        ], 200);
    }
}
