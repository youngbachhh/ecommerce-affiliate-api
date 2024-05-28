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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('price');
            $table->string('product_unit')->nullable();
            $table->string('quantity');
            $table->string('description')->nullable();
            $table->string('is_featured')->nullable();
            $table->string('is_new_arrival')->nullable();
            $table->string('reviews')->nullable();
            $table->unsignedBigInteger('categories_id');
            $table->unsignedBigInteger('discount_id')->nullable();
            $table->foreign('discount_id')->references('id')->on('discounts');
            $table->foreign('categories_id')->references('id')->on('categories');
            $table->enum('status', ['published', 'inactive', 'scheduled']);
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
        Schema::dropIfExists('products');
    }
};
