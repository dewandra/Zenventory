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
}
