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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            // Nama lokasi adalah gabungan dari semua elemen, dan harus unik
            // Contoh: Z1-A01-R01-B01 (Zone 1, Aisle 1, Rack 1, Bin 1)
            $table->string('name')->unique(); 
            $table->string('zone')->nullable();
            $table->string('aisle')->nullable(); // Lorong
            $table->string('rack')->nullable();  // Rak
            $table->string('bin')->nullable();   // Ambalan/Level
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
