<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alumnos', function (Blueprint $table) {
            $table->foreign(['id_usuario'], 'alumnos_ibfk_1')->references(['id'])->on('usuarios')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_usuario_tutor'], 'alumnos_ibfk_2')->references(['id'])->on('usuarios')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_periodo'], 'alumnos_ibfk_3')->references(['id'])->on('periodos_escolares')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_grupo'], 'alumnos_ibfk_4')->references(['id'])->on('grupos')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alumnos', function (Blueprint $table) {
            $table->dropForeign('alumnos_ibfk_1');
            $table->dropForeign('alumnos_ibfk_2');
            $table->dropForeign('alumnos_ibfk_3');
            $table->dropForeign('alumnos_ibfk_4');
        });
    }
};
