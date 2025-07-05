<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_batch_id',
        'type',
        'quantity_change',
        'from_location_id',
        'to_location_id',
        'user_id',
    ];
    
    // Relasi ke batch
    public function batch()
    {
        return $this->belongsTo(InventoryBatch::class, 'inventory_batch_id');
    }
    
    // Relasi ke lokasi asal
    public function fromLocation()
    {
        return $this->belongsTo(Location::class, 'from_location_id');
    }

    // Relasi ke lokasi tujuan
    public function toLocation()
    {
        return $this->belongsTo(Location::class, 'to_location_id');
    }

    // Relasi ke pengguna yang melakukan
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}