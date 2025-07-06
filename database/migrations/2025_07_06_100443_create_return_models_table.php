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
        Schema::create('return_models', function (Blueprint $table) {
            $table->id();
            $table->string('return_number')->unique();
            $table->string('customer_name')->nullable();
            $table->foreignId('order_id')->nullable()->constrained('orders'); // Opsional, jika retur terkait SO
            $table->string('status')->default('pending_inspection'); // pending_inspection, processed, cancelled
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_models');
    }
};
