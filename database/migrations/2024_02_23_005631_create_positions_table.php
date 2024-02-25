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
        Schema::create('positions', function (Blueprint $table) {
            $table->uuid('position_id')->primary();
            $table->foreignUuid('user_id')
                ->references('user_id')
                ->on('users');
            $table->string('position_name')->nullable();
            $table->string('position_status')->nullable();
            $table->string('position_location')->nullable();
            $table->string('position_sub_location')->nullable();
            $table->string('position_type')->nullable();
            $table->string('position_category')->nullable();
            $table->string('position_echelon')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};
