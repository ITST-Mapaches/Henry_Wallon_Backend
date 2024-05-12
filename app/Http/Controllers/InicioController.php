<?php

namespace App\Http\Controllers;

use DB;

class InicioController
{
    //| funcion para obtener a hombres
    private function getMens()
    {
        return DB::table('usuarios')
            ->join('sexos', 'usuarios.id_sexo', '=', 'sexos.id')
            ->where('sexos.nombre', '=', 'Masculino')
            ->count();
    }

    //| funcion para obtener a mujeres
    private function getWomans()
    {
        return DB::table('usuarios')
            ->join('sexos', 'usuarios.id_sexo', '=', 'sexos.id')
            ->where('sexos.nombre', '=', 'Femenino')
            ->count();
    }

    //| funcion para contar a cuentas activas
    private function getActiveAcounts()
    {
        return DB::table('usuarios')->where('activo', '=', 1)->count();
    }

    //| funcion para contar a cuentas inactivas
    private function getInactiveAcounts()
    {
        return DB::table('usuarios')->where('activo', '=', 0)->count();
    }

    // | funcion para contar cantidad de alumnos
    private function getAlumnos()
    {
        return DB::table('usuarios')->join('roles', 'usuarios.id_rol', '=', 'roles.id')->where('rol', '=', 'Alumno')->count();
    }

    // | funcion para contar cantidad de tutores
    private function getTutors()
    {
        return DB::table('usuarios')->join('roles', 'usuarios.id_rol', '=', 'roles.id')->where('rol', '=', 'Tutor')->count();
    }

    // | funcion para contar cantidad de docentes
    private function getDocents()
    {
        return DB::table('usuarios')->join('roles', 'usuarios.id_rol', '=', 'roles.id')->where('rol', '=', 'Docente')->count();
    }

    // | funcion para contar cantidad de administradores
    private function getAdmins()
    {
        return DB::table('usuarios')->join('roles', 'usuarios.id_rol', '=', 'roles.id')->where('rol', '=', 'Administrador')->count();
    }

    // > funcion para obtener todos los detalles para graficar
    public function getInformationRelevant()
    {
        $numero_hombres = $this->getMens();
        $numero_mujeres = $this->getWomans();
        $numero_cuentas_activas = $this->getActiveAcounts();
        $numero_cuentas_inactivas = $this->getInactiveAcounts();
        $numero_alumnos = $this->getAlumnos();
        $numero_tutores = $this->getTutors();
        $numero_docentes = $this->getDocents();
        $numero_administradores = $this->getAdmins();

        return response()->json([
            'status' => 200,
            'message' => 'informacion',
            'data' => [
                'numero_hombres' => $numero_hombres,
                'numero_mujeres' => $numero_mujeres,
                'numero_cuentas_activas' => $numero_cuentas_activas,
                'numero_cuentas_inactivas' => $numero_cuentas_inactivas,
                'numero_alumnos' => $numero_alumnos,
                'numero_docentes' => $numero_docentes,
                'numero_tutores' => $numero_tutores,
                'numero_administradores' => $numero_administradores,
            ]
        ], 200);
    }

}
