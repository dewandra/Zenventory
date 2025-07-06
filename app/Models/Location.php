<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', // Nama lokasi, harus unik
        'zone', // Zona
        'aisle', // Lorong
        'rack', // Rak
        'bin', // Ambalan/Level
    ];

    public function inventoryBatches()
    {
        return $this->hasMany(InventoryBatch::class);
    }
}