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
        Schema::create('asset_temporaries', function (Blueprint $table) {
            $table->uuid('asset_temporary_id')->primary();
            $table->foreignUuid('asset_temporary_user_id')
            ->nullable()
            ->references('user_id')
            ->on('users');
            $table->string('asset_temporary_bpad_code')->nullable();
            $table->string('asset_temporary_serial_number')->nullable();
            $table->string('asset_temporary_frame_number')->nullable();
            $table->string('asset_temporary_machine_number')->nullable();
            $table->string('asset_temporary_police_number')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_temporary_id');
    }
};
