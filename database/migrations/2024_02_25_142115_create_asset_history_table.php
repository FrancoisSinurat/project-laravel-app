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
        Schema::create('asset_histories', function (Blueprint $table) {
            $table->uuid('asset_history_id')->primary();
            $table->foreignUuid('asset_id')
            ->nullable()
            ->references('asset_id')
            ->on('assets');
            $table->string('asset_history_status');
            $table->string('historyable_id');
            $table->string('historyable_type');
            $table->foreignUuid('asset_history_user_id')
                ->nullable()
                ->references('user_id')
                ->on('users');
            $table->timestamps();
            $table->softDeletes();
            $table->index('historyable_id');
            $table->index('historyable_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_histories');
    }
};
