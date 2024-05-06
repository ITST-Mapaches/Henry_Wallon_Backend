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



//| informacion general de usuarios usando vista
Route::get('getUsuarios', [UsuariosGenericController::class, 'show']);
Route::get('getUsuario/{id}', [UsuariosGenericController::class, 'getUser']);
Route::get('getUsuarios/tutores', [UsuariosGenericController::class, 'getTutores']);
Route::get('getUsuarios/docentes', [UsuariosGenericController::class, 'getDocentes']);
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


// | asignaturas 
Route::get('asignaturas', [AsignaturasController::class, 'show']);
Route::get('getAsignatura/{id}', [AsignaturasController::class, 'getAsignatura']);
Route::post('asignaturas', [AsignaturasController::class, 'insert']);
Route::put('asignaturas/{id}', [AsignaturasController::class, 'update']);
Route::delete('asignaturas/{id}', [AsignaturasController::class, 'destroy']);
Route::post('asignaturadocentegrupo', [AsignaturasDocentesGruposController::class, 'insert']);
Route::get('asignaturadocentegrupo/{id_asignatura}', [AsignaturasDocentesGruposController::class, 'show']);
Route::put('asignaturadocentegrupo', [AsignaturasDocentesGruposController::class, 'update']);

// | sexos
Route::get('sexos', [SexosController::class, 'show']);

// | roles
Route::get('roles', [RolesController::class, 'show']);

// | periodos
Route::get('periodos', [PeriodosEscolaresController::class, 'show']);

// | grupos
Route::get('grupos', [GruposController::class, 'show']);
Route::post('grupos', [GruposController::class, 'insert']);
Route::put('grupos/{id}', [GruposController::class, 'update']);
Route::delete('grupos/{id}', [GruposController::class, 'destroy']);


Route::get('momentos', [MomentosController::class, 'show']);
Route::get('seguimientos', [SeguimientosIndividualesController::class, 'show']);
Route::get('periodocalificaciones', [PeriodoEvaluacionesController::class, 'show']);