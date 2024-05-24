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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('address')->nullable();
            $table->string('referral_code')->nullable();
            $table->string('referrer_id')->nullable();
            $table->string('total_revenue')->nullable();
            $table->string('wallet')->nullable();
            $table->string('bonus_wallet')->nullable();
            $table->string('phone')->nullable();
            $table->enum('status', ['active', 'inactive', 'pending'])->default('pending');
            // Tạo cột user_id
            $table->unsignedBigInteger('role_id');
            // Tạo ràng buộc khóa ngoại
            $table->foreign('role_id')->references('id')->on('roles');
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
