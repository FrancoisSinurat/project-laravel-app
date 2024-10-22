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
        Schema::create('asset_peminjamans', function (Blueprint $table) {
            $table->uuid('asset_peminjaman_id')->primary();
            $table->foreignUuid('asset_id')
            ->references('asset_id')
            ->on('assets');
            $table->foreignUuid('user_id')
                ->nullable()
                ->references('user_id')
                ->on('users');
            $table->dateTime('asset_peminjaman_datetime')->nullable();
            $table->dateTime('asset_pengembalian_datetime')->nullable();
            $table->string('asset_peminjaman_status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_peminjamans');

    }
};
