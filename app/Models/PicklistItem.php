<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PicklistItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'picklist_id', 'product_id', 'inventory_batch_id', 'location_id',
        'quantity_to_pick', 'product_name', 'product_sku', 'lpn', 'location_name'
    ];

    public function picklist()
    {
        return $this->belongsTo(Picklist::class);
    }
}
