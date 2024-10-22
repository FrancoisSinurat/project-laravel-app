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
        Schema::create('asalpengadaan_categories', function (Blueprint $table) {
            $table->uuid('asalpengadaan_category_id')->primary();
            $table->string('asalpengadaan_category_name');
            $table->string('asalpengadaan_category_code')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asalpengadaan_categories');
    }
};
