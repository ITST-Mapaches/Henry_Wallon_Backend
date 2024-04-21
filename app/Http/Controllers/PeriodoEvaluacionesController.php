<?php

namespace App\Http\Controllers;

use App\Models\PeriodosEvaluaciones;
use Illuminate\Http\Request;

class PeriodoEvaluacionesController
{
    //| funcion que evalua si esta activa la temporada de evaluaciones
    public function show()
    {
        $isActive = PeriodosEvaluaciones::all();

        if (empty($isActive) || count($isActive) <= 0) {
            return response()->json([
                'status' => 200,
                'message' => 'No se han encontrado información',
                'data' => []
            ], 200);
        }

        return response()->json([
            'status' => 200,
            'message' => 'El periodo de evaluciones se encuentra activo',
            'data' => $isActive[0]->activo
        ], 200);
    }
}
