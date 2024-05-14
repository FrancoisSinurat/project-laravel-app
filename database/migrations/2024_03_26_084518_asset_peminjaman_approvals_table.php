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
        Schema::create('asset_peminjaman_approvals', function (Blueprint $table) {
            $table->uuid('asset_peminjaman_approval_id')->primary();
            $table->foreignUuid('asset_peminjaman_id')
            ->references('asset_peminjaman_id')
            ->on('asset_peminjamans');
            $table->foreignUuid('user_id')
                ->nullable()
                ->references('user_id')
                ->on('users');
            $table->char('sort')->nullable();
            $table->string('asset_peminjaman_approval_status')->nullable();
            $table->date('asset_peminjaman_approval_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_peminjaman_approvals');

    }
};
