<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CycleCount extends Model
{
    use HasFactory;
    protected $fillable = ['reference_number', 'user_id', 'status', 'notes'];

    public function items() {
        return $this->hasMany(CycleCountItem::class);
    }
}
