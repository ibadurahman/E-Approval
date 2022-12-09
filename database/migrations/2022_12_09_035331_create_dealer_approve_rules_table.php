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
        Schema::create('dealer_approve_rules', function (Blueprint $table) {
            $table->unsignedBigInteger('dealer_id');
            $table->bigInteger('level_1_min_nominal');
            $table->unsignedBigInteger('level_1_position_id');
            $table->bigInteger('level_2_min_nominal');
            $table->unsignedBigInteger('level_2_position_id');
            $table->bigInteger('level_3_min_nominal');
            $table->unsignedBigInteger('level_3_position_id');
            $table->timestamps();

            $table->foreign('dealer_id')
                ->references('id')
                ->on('dealers')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('level_1_position_id')
                ->references('id')
                ->on('positions')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('level_2_position_id')
                ->references('id')
                ->on('positions')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('level_3_position_id')
                ->references('id')
                ->on('positions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dealer_approve_rules');
    }
};
