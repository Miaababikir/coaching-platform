<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoachStatistic extends Model
{
    protected $fillable = [
        'coach_id',
        'total_clients',
        'total_sessions',
        'completed_sessions',
        'scheduled_sessions',
    ];
}
