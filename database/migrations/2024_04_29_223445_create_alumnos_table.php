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
        Schema::create('alumnos', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_usuario')->index('id_usuario');
            $table->string('num_control', 15)->unique('num_control');
            $table->integer('id_usuario_tutor')->index('id_usuario_tutor');
            $table->integer('id_periodo')->index('id_periodo');
            $table->integer('id_grupo')->index('id_grupo');

            $table->primary(['id', 'id_usuario', 'id_usuario_tutor', 'id_periodo', 'id_grupo']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alumnos');
    }
};
