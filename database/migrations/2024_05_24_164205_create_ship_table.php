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
        Schema::create('ship', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['delivered', 'out for delivery', 'ready to pickup', 'dispatched']);
            $table->datetime('begin_time')->nullable();
            $table->datetime('expected_arrive')->nullable();
            $table->unsignedBigInteger('user_id'); // Thêm cột user_id
            $table->unsignedBigInteger('order_id'); // Thêm cột order_id
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('order_id')->references('id')->on('orders');
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
        Schema::dropIfExists('ship');
    }
};
