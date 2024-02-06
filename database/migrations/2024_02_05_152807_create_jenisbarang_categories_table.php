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
        Schema::create('jenisbarang_categories', function (Blueprint $table) {
            $table->uuid('jenisbarang_category_id')->primary();
            $table->uuid('item_category_id');
            $table->foreign('item_category_id')
                ->references('item_category_id')
                ->on('item_categories')
                ->restrictOnDelete();
            $table->string('jenisbarang_category_name');
            $table->string('jenisbarang_category_code');
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenisbarang_categories');
    }
};
