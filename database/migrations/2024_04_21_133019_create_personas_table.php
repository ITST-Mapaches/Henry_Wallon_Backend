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
        Schema::create('personas', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nombre', 40);
            $table->string('ap_paterno', 40);
            $table->string('ap_materno', 40);
            $table->date('nacimiento');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->nullable();
            $table->integer('id_sexo')->index('id_sexo');
            $table->integer('id_admin');

            $table->primary(['id', 'id_sexo']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personas');
    }
};
