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
        Schema::create('cuentas', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('url_image', 200)->nullable();
            $table->string('telefono', 12)->unique('telefono');
            $table->string('correo', 40)->unique('correo');
            $table->string('contrasena', 200);
            $table->boolean('activo')->default(true);
            $table->integer('id_persona')->index('id_persona');
            $table->integer('id_rol')->index('id_rol');
            $table->rememberToken();

            $table->primary(['id', 'id_persona']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cuentas');
    }
};
