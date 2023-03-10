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
        Schema::create('egresos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('egre_centro_dist');
            $table->foreign('egre_centro_dist')->references('id')->on('centro_distribucions');
            $table->unsignedBigInteger('egre_farmacia_id');
            $table->foreign('egre_farmacia_id')->references('id')->on('farmacias');
            $table->string("egre_fecha");
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
        Schema::dropIfExists('egresos');
    }
};
