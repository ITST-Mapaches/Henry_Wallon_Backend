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
        Schema::table('asignaturas_docentes_grupos', function (Blueprint $table) {
            $table->foreign(['id_asignatura'], 'asignaturas_docentes_grupos_ibfk_1')->references(['id'])->on('asignaturas')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_docente'], 'asignaturas_docentes_grupos_ibfk_2')->references(['id'])->on('docentes')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_grupo'], 'asignaturas_docentes_grupos_ibfk_3')->references(['id'])->on('grupos')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asignaturas_docentes_grupos', function (Blueprint $table) {
            $table->dropForeign('asignaturas_docentes_grupos_ibfk_1');
            $table->dropForeign('asignaturas_docentes_grupos_ibfk_2');
            $table->dropForeign('asignaturas_docentes_grupos_ibfk_3');
        });
    }
};
