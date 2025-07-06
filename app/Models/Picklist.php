<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Picklist extends Model
{
    use HasFactory;
    protected $fillable = ['picklist_number', 'order_id', 'user_id', 'status', 'completed_at'];

    public function items()
    {
        return $this->hasMany(PicklistItem::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
