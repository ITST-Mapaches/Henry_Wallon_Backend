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
        Schema::create('seguimientos_individuales', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('descripcion');
            $table->integer('id_alumno')->index('id_alumno');
            $table->integer('id_asignatura')->index('id_asignatura');
            $table->integer('id_docente')->index('id_docente');

            $table->primary(['id', 'id_alumno', 'id_asignatura', 'id_docente']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seguimientos_individuales');
    }
};
