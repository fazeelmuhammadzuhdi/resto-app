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
        Schema::create('order_line', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('orders')->nullable();
            $table->foreign('orders')->references('id')->on('orders')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('tables')->nullable();
            $table->foreign('tables')->references('id')->on('tables')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('foods')->nullable();
            $table->foreign('foods')->references('id')->on('foods')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->integer('harga');
            $table->integer('qty');
            $table->integer('subtotal');
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
        Schema::dropIfExists('order_line');
    }
};
