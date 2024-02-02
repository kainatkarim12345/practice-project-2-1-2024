<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_role_id')->default(1); 
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('profile')->nullable();
            $table->string('address')->nullable();
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('country_id');
            $table->string('zip_code')->nullable();
            $table->boolean('active')->default(1);
            $table->text('device_token')->nullable();
            $table->rememberToken();
            $table->foreign('user_role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
