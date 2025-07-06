<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Request;

class LogActivity
{
    public static function add($action, $description)
    {
        ActivityLog::create([
            'action' => $action,
            'description' => $description,
            'user_id' => auth()->check() ? auth()->id() : null,
            'ip_address' => Request::ip(),
            'user_agent' => Request::header('user-agent'),
        ]);
    }
}