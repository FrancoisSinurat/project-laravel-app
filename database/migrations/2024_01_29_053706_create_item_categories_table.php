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
        Schema::create('item_categories', function (Blueprint $table) {
            $table->uuid('item_category_id')->primary();
            $table->uuid('asset_category_id');
            $table->foreign('asset_category_id')
                ->references('asset_category_id')
                ->on('asset_categories')
                ->restrictOnDelete();
            $table->string('item_category_name');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_categories');
    }
};
