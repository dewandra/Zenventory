<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CycleCountItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'cycle_count_id', 'location_id', 'product_id', 'inventory_batch_id',
        'system_quantity', 'counted_quantity', 'variance', 'is_recounted', 'is_approved'
    ];
    
    public function product() { return $this->belongsTo(Product::class); }
    public function location() { return $this->belongsTo(Location::class); }
}
