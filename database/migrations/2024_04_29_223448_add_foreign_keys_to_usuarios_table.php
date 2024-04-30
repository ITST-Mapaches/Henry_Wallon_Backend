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
        Schema::table('usuarios', function (Blueprint $table) {
            $table->foreign(['id_sexo'], 'usuarios_ibfk_1')->references(['id'])->on('sexos')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_rol'], 'usuarios_ibfk_2')->references(['id'])->on('roles')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropForeign('usuarios_ibfk_1');
            $table->dropForeign('usuarios_ibfk_2');
        });
    }
};
