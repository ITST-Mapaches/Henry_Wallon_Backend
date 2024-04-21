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
        DB::statement("CREATE VIEW `cuentas_roles` AS select `p`.`id` AS `id`,`p`.`nombre` AS `nombre`,`c`.`correo` AS `correo`,`c`.`contrasena` AS `contrasena`,`r`.`rol` AS `rol` from ((`henry_wallon`.`roles` `r` join `henry_wallon`.`cuentas` `c` on((`r`.`id` = `c`.`id_rol`))) join `henry_wallon`.`personas` `p` on((`c`.`id_persona` = `p`.`id`)))");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `cuentas_roles`");
    }
};
