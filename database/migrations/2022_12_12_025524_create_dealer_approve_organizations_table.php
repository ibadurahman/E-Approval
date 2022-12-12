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
        Schema::create('dealer_approve_organizations', function (Blueprint $table) {
            $table->unsignedBigInteger('dealer_id');
            $table->unsignedBigInteger('level_1_position_id');
            $table->unsignedBigInteger('level_1_user_id');
            $table->unsignedBigInteger('level_2_position_id');
            $table->unsignedBigInteger('level_2_user_id');
            $table->unsignedBigInteger('level_3_position_id');
            $table->unsignedBigInteger('level_3_user_id');
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
            $table->foreign('level_1_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('level_2_position_id')
                ->references('id')
                ->on('positions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('level_2_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('level_3_position_id')
                ->references('id')
                ->on('positions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('level_3_user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('dealer_approve_organizations');
    }
};
