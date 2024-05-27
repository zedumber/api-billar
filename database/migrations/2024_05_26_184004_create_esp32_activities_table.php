<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEsp32ActivitiesTable extends Migration
{
    public function up()
    {
        Schema::create('esp32_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('esp32_id'); // Asegúrate de que el nombre sea correcto
            $table->String('e_s_p32_id');
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->nullable();
            $table->foreign('esp32_id')->references('id')->on('esp32s')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('esp32_activities');
    }
}
