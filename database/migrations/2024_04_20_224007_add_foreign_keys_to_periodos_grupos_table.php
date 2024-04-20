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
        Schema::table('periodos_grupos', function (Blueprint $table) {
            $table->foreign(['id_periodo'], 'periodos_grupos_ibfk_1')->references(['id'])->on('periodos_escolares')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_grupo'], 'periodos_grupos_ibfk_2')->references(['id'])->on('grupos')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('periodos_grupos', function (Blueprint $table) {
            $table->dropForeign('periodos_grupos_ibfk_1');
            $table->dropForeign('periodos_grupos_ibfk_2');
        });
    }
};
