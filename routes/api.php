<?php

use App\Http\Controllers\AlumnosController;
use App\Http\Controllers\AsignaturasController;
use App\Http\Controllers\AsignaturasDocentesGruposController;
use App\Http\Controllers\CuentasController;
use App\Http\Controllers\DocentesController;
use App\Http\Controllers\GeneracionesController;
use App\Http\Controllers\GruposController;
use App\Http\Controllers\KardexController;
use App\Http\Controllers\PeriodoEvaluacionesController;
use App\Http\Controllers\PeriodosEscolaresController;
use App\Http\Controllers\PersonasController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SeguimientosIndividualesController;
use App\Http\Controllers\SexosController;
use App\Http\Controllers\TutoresController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::get('sexos', [SexosController::class, 'show']);
Route::get('docentes', [DocentesController::class, 'show']);
Route::get('roles', [RolesController::class, 'show']);
Route::get('personas', [PersonasController::class, 'show']);
Route::get('cuentas', [CuentasController::class, 'show']);
Route::get('periodos', [PeriodosEscolaresController::class, 'show']);
Route::get('grupos', [GruposController::class, 'show']);
Route::get('asignaturas', [AsignaturasController::class, 'show']);
Route::get('kardex', [KardexController::class, 'show']);
Route::get('generaciones', [GeneracionesController::class, 'show']);
Route::get('tutores', [TutoresController::class, 'show']);
Route::get('alumnos', [AlumnosController::class, 'show']);
Route::get('seguimientos', [SeguimientosIndividualesController::class, 'show']);
Route::get('asignaturadocentegrupo', [AsignaturasDocentesGruposController::class, 'show']);
Route::get('periodocalificaciones', [PeriodoEvaluacionesController::class, 'show']);