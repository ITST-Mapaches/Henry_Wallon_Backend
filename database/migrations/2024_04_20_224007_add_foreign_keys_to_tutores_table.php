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
        Schema::table('tutores', function (Blueprint $table) {
            $table->foreign(['id_persona'], 'tutores_ibfk_1')->references(['id'])->on('personas')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_admin'], 'tutores_ibfk_2')->references(['id'])->on('personas')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tutores', function (Blueprint $table) {
            $table->dropForeign('tutores_ibfk_1');
            $table->dropForeign('tutores_ibfk_2');
        });
    }
};
