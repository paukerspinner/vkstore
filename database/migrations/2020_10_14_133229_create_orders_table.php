<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shopcart_id')->unique();
            $table->string('ship_name', 128);
            $table->string('ship_city', 128);
            $table->string('ship_district', 128);
            $table->string('ship_ward', 128);
            $table->string('ship_address', 256);
            $table->string('ship_phone', 16);
            $table->string('ship_note')->nullable();
            $table->tinyInteger('status');
            $table->foreign('shopcart_id')->references('id')->on('shopcarts')->onDelete('cascade');
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
        Schema::dropIfExists('orders');
    }
}
