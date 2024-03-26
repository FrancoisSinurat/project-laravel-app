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
            $table->string('asset_history_status');
            $table->string('asset_historyable_id');
            $table->string('asset_historyable_type');
            $table->foreignUuid('asset_history_user_id')
                ->nullable()
                ->references('user_id')
                ->on('users');
            $table->timestamps();
            $table->softDeletes();
            $table->index('asset_historyable_id');
            $table->index('asset_historyable_type');
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