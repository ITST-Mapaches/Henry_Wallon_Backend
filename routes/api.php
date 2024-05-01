<?php

use App\Http\Controllers\AlumnosController;
use App\Http\Controllers\AsignaturasController;
use App\Http\Controllers\AsignaturasDocentesGruposController;
use App\Http\Controllers\DocentesController;
use App\Http\Controllers\GruposController;
use App\Http\Controllers\MomentosController;
use App\Http\Controllers\PeriodoEvaluacionesController;
use App\Http\Controllers\PeriodosEscolaresController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SeguimientosIndividualesController;
use App\Http\Controllers\SexosController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\UsuariosGenericController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::get('sexos', [SexosController::class, 'show']);
Route::get('roles', [RolesController::class, 'show']);

//| informacion general de usuarios usando vista
Route::get('getUsuarios', [UsuariosGenericController::class, 'show']);
Route::get('getUsuario/{id}', [UsuariosGenericController::class, 'getUser']);
Route::get('getUsuarios/tutores', [UsuariosGenericController::class, 'getTutores']);
Route::delete('deleteUser/{idUser}', [UsuariosGenericController::class, 'destroy']);

// | docentes
Route::post('docentes', [DocentesController::class, 'insert']);
Route::put('docentes/{id}', [DocentesController::class, 'update']);


//| alumnos
Route::post('alumnos', [AlumnosController::class, 'insert']);
Route::put('alumnos/{id}', [AlumnosController::class, 'update']);

// |usuarios
Route::post('usuarios', [UsuariosController::class, 'insert']);
Route::put('usuarios/{id}', [UsuariosController::class, 'update']);


Route::get('periodos', [PeriodosEscolaresController::class, 'show']);
Route::get('grupos', [GruposController::class, 'show']);
Route::get('asignaturas', [AsignaturasController::class, 'show']);
Route::get('momentos', [MomentosController::class, 'show']);
Route::get('seguimientos', [SeguimientosIndividualesController::class, 'show']);
Route::get('asignaturadocentegrupo', [AsignaturasDocentesGruposController::class, 'show']);
Route::get('periodocalificaciones', [PeriodoEvaluacionesController::class, 'show']);