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
        Schema::create('asset_useds', function (Blueprint $table) {
            $table->uuid('asset_used_id')->primary();
            $table->foreignUuid('asset_id')
                ->references('asset_id')
                ->on('assets');
            $table->string('asset_used_status')->nullable();
            $table->dateTime('asset_handover_date')->nullable();
            $table->dateTime('asset_used_start')->nullable();
            $table->dateTime('asset_used_end')->nullable();
            $table->foreignUuid('asset_used_by')
                ->nullable()
                ->references('user_id')
                ->on('users');
            $table->foreignUuid('asset_handover_by')
                ->nullable()
                ->references('user_id')
                ->on('users');
            $table->string('asset_handover_file')->nullable();
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
