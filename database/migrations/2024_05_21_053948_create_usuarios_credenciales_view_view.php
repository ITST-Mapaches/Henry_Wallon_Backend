<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW `usuarios_credenciales_view` AS select `u`.`id` AS `id`,`u`.`nombre` AS `nombre`,`u`.`nombre_usuario` AS `nombre_usuario`,`u`.`contrasena` AS `password`,`r`.`rol` AS `rol` from (`henry_wallon`.`usuarios` `u` join `henry_wallon`.`roles` `r` on((`u`.`id_rol` = `r`.`id`)))");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `usuarios_credenciales_view`");
    }
};
