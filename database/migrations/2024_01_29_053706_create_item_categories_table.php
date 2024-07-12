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
            $table->foreignUuid('asset_category_id')
                ->references('asset_category_id')
                ->on('asset_categories');
            $table->string('item_category_name');
            $table->string('item_category_code');
            $table->string('item_category_icon');
            $table->string('item_category_color');
            $table->string('item_category_text');
            $table->string('item_category_color_bg');
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
