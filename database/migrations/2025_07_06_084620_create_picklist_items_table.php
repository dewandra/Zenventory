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
        Schema::create('picklist_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('picklist_id')->constrained('picklists')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('inventory_batch_id')->constrained('inventory_batches');
            $table->foreignId('location_id')->constrained('locations');
            $table->integer('quantity_to_pick');
            // Snapshot data pada saat picklist dibuat
            $table->string('product_name');
            $table->string('product_sku');
            $table->string('lpn');
            $table->string('location_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('picklist_items');
    }
};
