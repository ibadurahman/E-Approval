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
            $table->string('po_num');
            $table->unsignedBigInteger('dealer_id');
            $table->unsignedBigInteger('created_by');
            $table->boolean('level_1_is_approved');
            $table->unsignedBigInteger('level_1_');
            $table->boolean('level_2_is_approved');
            $table->boolean('level_3_is_approved');
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
        Schema::dropIfExists('purchase_orders');
    }
};
