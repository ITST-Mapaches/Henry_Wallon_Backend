<?php

namespace App\Http\Controllers;

use App\Models\Cuentas;
use Illuminate\Http\Request;
use DB;

class CuentasController
{
    //| funcion para retornar todos los registros de la tabla
    public function show()
    {
        //hacemos un select all de la tabla
        $cuentas = Cuentas::all();

        //si cuentas está vacío
        if (empty($cuentas) || count($cuentas) <= 0) {
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
            'data' => $cuentas
        ], 200);
    }
}
