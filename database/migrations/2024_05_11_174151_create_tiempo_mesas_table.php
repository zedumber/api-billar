<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiempoMesasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tiempo_mesas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mesa_id');
            $table->string('billar');
            $table->string('duracion'); // Duración en segundos
            $table->boolean('pagado')->default(false);
            $table->foreign('mesa_id')->references('id')->on('mesas');
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tiempo_mesas');
    }
}
