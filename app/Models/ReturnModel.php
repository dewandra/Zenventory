<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnModel extends Model
{
    use HasFactory;
    
    // Memberitahu Laravel bahwa model ini menggunakan tabel 'returns'
    protected $table = 'return_models';

    protected $fillable = ['return_number', 'customer_name', 'order_id', 'status', 'notes', 'user_id'];

    public function items()
    {
        // Pastikan foreign key benar jika berbeda dari standar
        return $this->hasMany(ReturnItem::class, 'return_id');
    }
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}