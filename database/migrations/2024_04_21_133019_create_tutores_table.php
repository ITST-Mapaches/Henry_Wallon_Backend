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
        Schema::create('tutores', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_persona')->index('id_persona');
            $table->string('ocupacion', 50);
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
        Schema::dropIfExists('tutores');
    }
};
