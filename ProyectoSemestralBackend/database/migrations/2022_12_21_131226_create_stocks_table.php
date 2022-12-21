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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('scd_id_medicamento');
            $table->foreign('scd_id_medicamento')->references('id')->on('medicamentos');
            $table->unsignedBigInteger('scd_centro_dist');
            $table->foreign('scd_centro_dist')->references('id')->on('centro_distribucions');
            $table->integer('scd_cantidad');
            $table->integer('scd_lote');
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
        Schema::dropIfExists('stocks');
    }
};
