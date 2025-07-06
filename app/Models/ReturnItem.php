<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnItem extends Model
{
    use HasFactory;

    protected $fillable = ['return_id', 'product_id', 'quantity', 'reason', 'disposition'];
    
    public function product() 
    {
        return $this->belongsTo(Product::class);
    }

    public function returnModel()
    {
        return $this->belongsTo(ReturnModel::class, 'return_id');
    }
}