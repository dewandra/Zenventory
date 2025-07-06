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
        Schema::create('picklists', function (Blueprint $table) {
            $table->id();
            $table->string('picklist_number')->unique();
            $table->foreignId('order_id')->constrained('orders');
            $table->foreignId('user_id')->constrained('users'); // Pengguna yang membuat picklist
            $table->string('status')->default('pending'); // pending, in_progress, completed
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('picklists');
    }
};
