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
        Schema::table('seguimientos_individuales', function (Blueprint $table) {
            $table->foreign(['id_alumno'], 'seguimientos_individuales_ibfk_1')->references(['id'])->on('alumnos')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_asignatura'], 'seguimientos_individuales_ibfk_2')->references(['id'])->on('asignaturas')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_docente'], 'seguimientos_individuales_ibfk_3')->references(['id'])->on('docentes')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seguimientos_individuales', function (Blueprint $table) {
            $table->dropForeign('seguimientos_individuales_ibfk_1');
            $table->dropForeign('seguimientos_individuales_ibfk_2');
            $table->dropForeign('seguimientos_individuales_ibfk_3');
        });
    }
};
