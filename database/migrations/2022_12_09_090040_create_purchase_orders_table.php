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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('po_num')->unique();
            $table->unsignedBigInteger('dealer_id');
            $table->unsignedBigInteger('created_by');
            $table->dateTime('release_date');
            $table->boolean('level_1_is_approved')->nullable();
            $table->unsignedBigInteger('level_1_approved_by')->nullable();
            $table->dateTime('level_1_approved_time')->nullable();
            $table->boolean('level_2_is_approved')->nullable();
            $table->unsignedBigInteger('level_2_approved_by')->nullable();
            $table->dateTime('level_2_approved_time')->nullable();
            $table->boolean('level_3_is_approved')->nullable();
            $table->unsignedBigInteger('level_3_approved_by')->nullable();
            $table->dateTime('level_3_approved_time')->nullable();
            $table->enum('status',['review','approved','not approve','closed']);
            $table->timestamps();

            $table->foreign('dealer_id')
                ->references('id')
                ->on('dealers')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('level_1_approved_by')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('level_2_approved_by')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('level_3_approved_by')
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
        Schema::dropIfExists('purchase_orders');
    }
};
