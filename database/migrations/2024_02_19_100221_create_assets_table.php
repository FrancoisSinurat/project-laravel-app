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
        Schema::create('assets', function (Blueprint $table) {
            $table->uuid('asset_id')->primary();
            $table->foreignUuid('asset_category_id')
                ->references('asset_category_id')
                ->on('asset_categories');
            $table->foreignUuid('item_category_id')
                ->references('item_category_id')
                ->on('item_categories');
            $table->foreignUuid('item_id')
                ->references('item_id')
                ->on('items');
            $table->foreignUuid('item_type_id')
                ->nullable()
                ->references('item_type_id')
                ->on('item_types');
            $table->foreignUuid('item_brand_id')
                ->nullable()
                ->references('item_brand_id')
                ->on('item_brands');
            $table->foreignUuid('bidang_category_id')
                ->nullable()
                ->references('bidang_category_id')
                ->on('bidang_categories');
            $table->foreignUuid('bahan_category_id')
                ->nullable()
                ->references('bahan_category_id')
                ->on('bahan_categories');
            $table->foreignUuid('asaloleh_category_id')
                ->nullable()
                ->references('asaloleh_category_id')
                ->on('asaloleh_categories');
            $table->date('asset_asaloleh_date')->nullable();
            $table->integer('asset_procurement_year')->nullable();
            $table->string('asset_code')->nullable();
            $table->string('asset_name')->nullable();
            $table->text('asset_note')->nullable();
            $table->text('asset_specification')->nullable();
            $table->string('asset_serial_number')->nullable();
            $table->string('asset_frame_number')->nullable();
            $table->string('asset_machine_number')->nullable();
            $table->string('asset_police_number')->nullable();
            $table->float('asset_price', 20, 2)->nullable();
            $table->float('asset_qty', 8, 2)->nullable();
            $table->float('asset_shrinkage', 4, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
