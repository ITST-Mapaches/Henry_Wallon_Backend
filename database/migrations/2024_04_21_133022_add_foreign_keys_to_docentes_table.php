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
        Schema::table('docentes', function (Blueprint $table) {
            $table->foreign(['id_persona'], 'docentes_ibfk_1')->references(['id'])->on('personas')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_admin'], 'docentes_ibfk_2')->references(['id'])->on('personas')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('docentes', function (Blueprint $table) {
            $table->dropForeign('docentes_ibfk_1');
            $table->dropForeign('docentes_ibfk_2');
        });
    }
};
