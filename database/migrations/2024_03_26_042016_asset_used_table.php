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
        Schema::create('asset_used', function (Blueprint $table) {
            $table->uuid('asset_used_id')->primary();
            $table->foreignUuid('asset_id')
            ->references('asset_id')
            ->on('assets');
            $table->foreignUuid('user_id')
                ->nullable()
                ->references('user_id')
                ->on('users');
            $table->date('asset_used_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_used');
    }
};
