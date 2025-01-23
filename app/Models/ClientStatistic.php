<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientStatistic extends Model
{
    protected $fillable = [
        'client_id',
        'coach_id',
        'total_sessions',
        'completed_sessions',
        'scheduled_sessions',
    ];
}
