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
        Schema::create('docentes', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('cedula_prof', 20)->unique('cedula_prof');
            $table->integer('id_persona')->index('id_persona');
            $table->integer('id_admin')->index('id_admin');

            $table->primary(['id', 'id_persona', 'id_admin']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('docentes');
    }
};
