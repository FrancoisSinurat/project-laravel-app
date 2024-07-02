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
        Schema::create('asset_groups', function (Blueprint $table) {
            $table->uuid('asset_group_id')->primary();
            $table->string('asset_document_number')
                ->index()
                ->nullable();
            $table->foreignUuid('asalpengadaan_category_id')
                ->nullable()
                ->references('asalpengadaan_category_id')
                ->on('asalpengadaan_categories');
            $table->foreignUuid('asaloleh_category_id')
                ->nullable()
                ->references('asaloleh_category_id')
                ->on('asaloleh_categories');
            $table->date('asset_asaloleh_date')->nullable();
            $table->integer('asset_procurement_year')->nullable();
            $table->longText('asset_documents')->nullable();
            $table->bigInteger('asset_group_items')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_groups');
    }
};
