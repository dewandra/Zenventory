<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * PERBAIKAN: Tambahkan properti $fillable di sini.
     *
     * @var array
     */
    protected $fillable = [
        'action',
        'description',
        'user_id',
        'ip_address',
        'user_agent',
    ];
}
