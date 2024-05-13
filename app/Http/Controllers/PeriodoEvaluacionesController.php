<?php

namespace App\Http\Controllers;

use App\Models\PeriodosEvaluaciones;

class PeriodoEvaluacionesController
{
    //| funcion que evalua si esta activa la temporada de evaluaciones
    public function show()
    {
        $isActive = PeriodosEvaluaciones::first();

        if (!$isActive) {
            return response()->json([
                'status' => 200,
                'message' => 'No se han encontrado información',
                'data' => []
            ], 200);
        }

        return response()->json([
            'status' => 200,
            'message' => 'El periodo de evaluciones se encuentra activo',
            'data' => $isActive->activo
        ], 200);
    }

    //| funcion para actualizar la temporada de evaluaciones
    public function update()
    {
        $isActive = PeriodosEvaluaciones::first();

        if (!$isActive) {
            return response()->json([
                'status' => 200,
                'message' => 'No se han encontrado información',
                'data' => []
            ], 200);
        }

        // actualiza por
        $isActive->update(['activo' => !$isActive->activo]);

        return response()->json([
            'status' => 200,
            'message' => 'el periodo se ha actualizado con éxito',
            'data' => $isActive->activo
        ], 200);
    }
}
