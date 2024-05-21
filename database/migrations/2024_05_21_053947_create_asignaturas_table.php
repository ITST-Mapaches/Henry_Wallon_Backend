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
        Schema::create('asignaturas', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('clave', 10)->unique('clave');
            $table->string('nombre', 50)->unique('nombre');
            $table->text('objetivo');
            $table->integer('id_periodo')->index('id_periodo');
            $table->tinyInteger('calificacion_aprobatoria');

            $table->primary(['id', 'id_periodo']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asignaturas');
    }
};
