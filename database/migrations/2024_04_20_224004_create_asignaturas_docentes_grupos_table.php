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
        Schema::create('asignaturas_docentes_grupos', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_asignatura')->index('id_asignatura');
            $table->integer('id_docente')->index('id_docente');
            $table->integer('id_grupo')->index('id_grupo');

            $table->primary(['id', 'id_asignatura', 'id_docente', 'id_grupo']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asignaturas_docentes_grupos');
    }
};
