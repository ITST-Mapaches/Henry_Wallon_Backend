<?php

namespace App\Http\Controllers;

use App\Models\Personas;
use Illuminate\Http\Request;

class PersonasController
{
    //| funcion para retornar todos los registros
    public function show()
    {
        //hacemos un select all de la tabla
        $personas = Personas::all();

        //si personas está vacío
        if (empty($personas) || count($personas) <= 0) {
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
            'data' => $personas
        ], 200);
    }
}
