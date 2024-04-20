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
        Schema::create('kardex', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_alumno')->index('id_alumno');
            $table->integer('id_asignatura')->index('id_asignatura');
            $table->tinyInteger('cal_primer_momento');
            $table->tinyInteger('cal_segundo_momento');
            $table->tinyInteger('cal_tercer_momento');

            $table->primary(['id', 'id_alumno', 'id_asignatura']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kardex');
    }
};
