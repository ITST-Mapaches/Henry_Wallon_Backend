<?php

use App\Http\Controllers\AlumnosController;
use App\Http\Controllers\AsignaturasController;
use App\Http\Controllers\AsignaturasDocentesGruposController;
use App\Http\Controllers\AuthController;
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

// !ruta para login
Route::post('login', [AuthController::class, 'login']);

// !proteccion de rutas con autenticacion
Route::middleware(['auth:sanctum'])->group(
    function () {
        //| informacion general de usuarios usando vista
        Route::get('getUsuarios', [UsuariosGenericController::class, 'show'])->middleware('restrictRole:Administrador');
        Route::get('getUsuario/{id}', [UsuariosGenericController::class, 'getUser'])->middleware('restrictRole:Administrador');
        Route::get('getUsuarios/tutores', [UsuariosGenericController::class, 'getTutores'])->middleware('restrictRole:Administrador');
        Route::get('getUsuarios/docentes', [UsuariosGenericController::class, 'getDocentes'])->middleware('restrictRole:Administrador');
        Route::delete('deleteUser/{idUser}', [UsuariosGenericController::class, 'destroy'])->middleware('restrictRole:Administrador');


        // | docentes
        Route::post('docentes', [DocentesController::class, 'insert'])->middleware('restrictRole:Administrador');
        Route::put('docentes/{id}', [DocentesController::class, 'update'])->middleware('restrictRole:Administrador');


        //| alumno->middleware('restrictRole:Administrador');
        Route::post('alumnos', [AlumnosController::class, 'insert'])->middleware('restrictRole:Administrador');
        Route::put('alumnos/{id}', [AlumnosController::class, 'update'])->middleware('restrictRole:Administrador');

        // |usuario->middleware('restrictRole:Administrador');
        Route::post('usuarios', [UsuariosController::class, 'insert'])->middleware('restrictRole:Administrador');
        Route::put('usuarios/{id}', [UsuariosController::class, 'update'])->middleware('restrictRole:Administrador');


        // | asignaturas->middleware('restrictRole:Administrador');
        Route::get('asignaturas', [AsignaturasController::class, 'show'])->middleware('restrictRole:Administrador');
        Route::get('getAsignatura/{id}', [AsignaturasController::class, 'getAsignatura'])->middleware('restrictRole:Administrador');
        Route::post('asignaturas', [AsignaturasController::class, 'insert'])->middleware('restrictRole:Administrador');
        Route::put('asignaturas/{id}', [AsignaturasController::class, 'update'])->middleware('restrictRole:Administrador');
        Route::delete('asignaturas/{id}', [AsignaturasController::class, 'destroy'])->middleware('restrictRole:Administrador');
        Route::post('asignaturadocentegrupo', [AsignaturasDocentesGruposController::class, 'insert'])->middleware('restrictRole:Administrador');
        Route::get('asignaturadocentegrupo/{id_asignatura}', [AsignaturasDocentesGruposController::class, 'show'])->middleware('restrictRole:Administrador');
        Route::put('asignaturadocentegrupo', [AsignaturasDocentesGruposController::class, 'update'])->middleware('restrictRole:Administrador');


        // | sexos
        Route::get('sexos', [SexosController::class, 'show'])->middleware('restrictRole:Administrador');


        // | roles
        Route::get('roles', [RolesController::class, 'show'])->middleware('restrictRole:Administrador');


        // | periodos
        Route::get('periodos', [PeriodosEscolaresController::class, 'show'])->middleware('restrictRole:Administrador');;
        Route::get('getPeriodo/{id}', [PeriodosEscolaresController::class, 'getPeriodo'])->middleware('restrictRole:Administrador');;
        Route::post('periodos', [PeriodosEscolaresController::class, 'insert'])->middleware('restrictRole:Administrador');;
        Route::put('periodos/{id}', [PeriodosEscolaresController::class, 'update'])->middleware('restrictRole:Administrador');;
        Route::delete('periodos/{id}', [PeriodosEscolaresController::class, 'destroy'])->middleware('restrictRole:Administrador');;


        // | grupos
        Route::get('grupos', [GruposController::class, 'show'])->middleware('restrictRole:Administrador');;
        Route::post('grupos', [GruposController::class, 'insert'])->middleware('restrictRole:Administrador');;
        Route::put('grupos/{id}', [GruposController::class, 'update'])->middleware('restrictRole:Administrador');;
        Route::delete('grupos/{id}', [GruposController::class, 'destroy'])->middleware('restrictRole:Administrador');;


        Route::get('momentos', [MomentosController::class, 'show']);
        Route::get('seguimientos', [SeguimientosIndividualesController::class, 'show']);
        Route::get('periodocalificaciones', [PeriodoEvaluacionesController::class, 'show']);

        // !cerrar sesion
        //cerrar sesión
        Route::get('logout', [AuthController::class, 'logout']);
    }
);

