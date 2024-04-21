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
        Schema::table('kardex', function (Blueprint $table) {
            $table->foreign(['id_alumno'], 'kardex_ibfk_1')->references(['id'])->on('alumnos')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_asignatura'], 'kardex_ibfk_2')->references(['id'])->on('asignaturas')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kardex', function (Blueprint $table) {
            $table->dropForeign('kardex_ibfk_1');
            $table->dropForeign('kardex_ibfk_2');
        });
    }
};
