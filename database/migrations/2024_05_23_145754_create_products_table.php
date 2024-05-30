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
            $table->string('name')->index();
            $table->unsignedBigInteger('price');
            $table->string('product_unit')->nullable();
            $table->string('quantity');
            $table->text('description');
            $table->string('is_featured')->nullable();
            $table->string('is_new_arrival')->nullable();
            $table->decimal('commission_rate', 5, 2);
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('discount_id')->nullable();
            $table->foreign('discount_id')->references('id')->on('discounts')->onDelete('set null');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('restrict');
            $table->enum('status', ['published', 'inactive', 'scheduled'])->index();
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
