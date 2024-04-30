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
        DB::statement("CREATE VIEW `usuarios_info_view` AS select `u`.`id` AS `id`,concat(`u`.`nombre`,' ',`u`.`ap_paterno`,' ',`u`.`ap_materno`) AS `name`,`u`.`nombre_usuario` AS `username`,`u`.`activo` AS `activo`,`s`.`nombre` AS `sexo`,`r`.`rol` AS `rol` from ((`henry_wallon`.`sexos` `s` join `henry_wallon`.`usuarios` `u` on((`s`.`id` = `u`.`id_sexo`))) join `henry_wallon`.`roles` `r` on((`u`.`id_rol` = `r`.`id`))) order by `u`.`id`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `usuarios_info_view`");
    }
};
