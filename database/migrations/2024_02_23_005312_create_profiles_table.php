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
        Schema::create('profiles', function (Blueprint $table) {
            $table->uuid('profile_id')->primary();
            $table->foreignUuid('user_id')
                ->references('user_id')
                ->on('users');
            $table->string('profile_pegawai_id')->nullable();
            $table->string('profile_nip')->nullable();
            $table->string('profile_photo')->nullable();
            $table->string('profile_photo_thumbnail')->nullable();
            $table->string('profile_signature')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
