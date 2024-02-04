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
            $table->uuid('user_id')->primary();
            $table->string('user_fullname')->nullable();
            $table->string('user_name');
            $table->string('user_nrk')->nullable();
            $table->string('user_email');
            $table->longText('user_address')->nullable();
            $table->string('user_phone')->nullable();
            $table->timestamp('user_email_verified_at')->nullable();
            $table->string('user_password');
            $table->boolean('user_status')->default(true);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
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
