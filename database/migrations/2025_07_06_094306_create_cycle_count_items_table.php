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
        Schema::create('cycle_count_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cycle_count_id')->constrained('cycle_counts')->onDelete('cascade');
            $table->foreignId('location_id')->constrained('locations');
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('inventory_batch_id')->constrained('inventory_batches');
            $table->integer('system_quantity');
            $table->integer('counted_quantity')->nullable();
            $table->integer('variance'); // Selisih
            $table->boolean('is_recounted')->default(false);
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cycle_count_items');
    }
};
