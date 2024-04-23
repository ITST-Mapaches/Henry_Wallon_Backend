<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nombre', 40);
            $table->string('ap_paterno', 40);
            $table->string('ap_materno', 40);
            $table->date('nacimiento');
            $table->string('telefono', 12)->unique('telefono');
            $table->string('nombre_usuario', 40)->unique('nombre_usuario');
            $table->string('contrasena', 200);
            $table->boolean('activo')->default(true);
            $table->integer('id_sexo')->index('id_sexo');
            $table->integer('id_rol')->index('id_rol');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->nullable();
            $table->rememberToken();
            $table->primary(['id', 'id_sexo', 'id_rol']);
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('usuario_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
