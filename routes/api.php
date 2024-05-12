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

//: login
Route::post('login', [AuthController::class, 'login']);

//: proteccion de rutas con autenticacion
Route::middleware(['auth:sanctum'])->group(
    function () {
        //> rol Administrador

        //| informacion general de usuarios usando vista
        Route::get('getUsuarios', [UsuariosGenericController::class, 'show'])->middleware('restrictRole:Administrador');
        Route::get('getUsuario/{id}', [UsuariosGenericController::class, 'getUser'])->middleware('restrictRole:Administrador');
        Route::get('getUsuarios/tutores', [UsuariosGenericController::class, 'getTutores'])->middleware('restrictRole:Administrador');
        Route::get('getUsuarios/docentes', [UsuariosGenericController::class, 'getDocentes'])->middleware('restrictRole:Administrador');
        Route::delete('deleteUser/{idUser}', [UsuariosGenericController::class, 'destroy'])->middleware('restrictRole:Administrador');


        // | docentes
        Route::post('docentes', [DocentesController::class, 'insert'])->middleware('restrictRole:Administrador');
        Route::put('docentes/{id}', [DocentesController::class, 'update'])->middleware('restrictRole:Administrador');


        // | alumno
        Route::post('alumnos', [AlumnosController::class, 'insert'])->middleware('restrictRole:Administrador');
        Route::put('alumnos/{id}', [AlumnosController::class, 'update'])->middleware('restrictRole:Administrador');

        // | usuario
        Route::post('usuarios', [UsuariosController::class, 'insert'])->middleware('restrictRole:Administrador');
        Route::put('usuarios/{id}', [UsuariosController::class, 'update'])->middleware('restrictRole:Administrador');


        // | asignaturas
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
        Route::get('periodos', [PeriodosEscolaresController::class, 'show'])->middleware('restrictRole:Administrador');
        Route::get('getPeriodo/{id}', [PeriodosEscolaresController::class, 'getPeriodo'])->middleware('restrictRole:Administrador');
        Route::post('periodos', [PeriodosEscolaresController::class, 'insert'])->middleware('restrictRole:Administrador');
        Route::put('periodos/{id}', [PeriodosEscolaresController::class, 'update'])->middleware('restrictRole:Administrador');
        Route::delete('periodos/{id}', [PeriodosEscolaresController::class, 'destroy'])->middleware('restrictRole:Administrador');


        // | grupos
        Route::get('grupos', [GruposController::class, 'show'])->middleware('restrictRole:Administrador');
        Route::post('grupos', [GruposController::class, 'insert'])->middleware('restrictRole:Administrador');
        Route::put('grupos/{id}', [GruposController::class, 'update'])->middleware('restrictRole:Administrador');
        Route::delete('grupos/{id}', [GruposController::class, 'destroy'])->middleware('restrictRole:Administrador');


        // | periodos de calificaciones
        Route::get('periodocalificaciones', [PeriodoEvaluacionesController::class, 'show']);

        
        //> rol Docente

        // | asignaturas impartidas por docentes
        Route::get('getMattersByDocent/{id}', [AsignaturasDocentesGruposController::class, 'getMattersByDocent'])->middleware('restrictRole:Docente');


        // | momentos
        Route::get('momentos', [MomentosController::class, 'show'])->middleware('restrictRole:Docente');
        // actualizar calificaciones de estudiante en una asignatura
        Route::put('momentos/{num_control}/{id_asignatura}', [MomentosController::class, 'updateMomentos'])->middleware('restrictRole:Docente');

        // | obtener calificaciones de alumnos de momentos en una materia grupo y prefijo de grupo
        Route::get('getMomentosBySubjectGroupPeriod/{id_asignatura}/{num_period}/{pref_grupo}', [AlumnosController::class, 'getMomentosBySubjectGroupPeriod'])->middleware('restrictRole:Docente');

        //: cerrar sesion
        Route::get('logout', [AuthController::class, 'logout']);
    }
);


// | seguimientos individuales
        // obtener todos los seguimientos
        Route::get('seguimientos', [SeguimientosIndividualesController::class, 'show']);
        // obtener el seguimiento de un estudiante en especifico en una materia
        Route::get('seguimiento/{num_control}/{id_asignatura}', [SeguimientosIndividualesController::class, 'getSeguimientoByStudentControl']);
        // crear seguimiento de un estudiante en una materia
        Route::post('seguimientos/{num_control}/{id_asignatura}/{id_user}', [SeguimientosIndividualesController::class, 'insert']);
        // actualizar un seguimiento
        Route::put('seguimientos/{seguimiento_id}', [SeguimientosIndividualesController::class, 'update']);
        // eliminar un seguimiento
        Route::delete('seguimientos/{seguimiento_id}', [SeguimientosIndividualesController::class, 'destroy']);