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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('wallet_id');
            $table->unsignedInteger('user_id');
            $table->bigInteger('total_revenue')->default(0);
            $table->foreign('user_id')->references('id')->on('users');
            $table->tinyInteger('type')->default(1); //1 : ví thường, 2: ví bonus
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
        Schema::dropIfExists('wallets');
    }
};
