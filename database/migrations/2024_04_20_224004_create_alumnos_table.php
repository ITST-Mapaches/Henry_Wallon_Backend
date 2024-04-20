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
            $table->integer('id_persona')->index('id_persona');
            $table->string('num_control', 15)->unique('num_control');
            $table->integer('id_tutor')->index('id_tutor');
            $table->integer('id_periodo')->index('id_periodo');
            $table->integer('id_grupo')->index('id_grupo');
            $table->integer('id_admin')->index('id_admin');
            $table->integer('id_generacion')->index('id_generacion');

            $table->primary(['id', 'id_tutor', 'id_periodo', 'id_grupo', 'id_admin', 'id_generacion']);
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
