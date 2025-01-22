<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ClientCoach extends Pivot
{
    protected $table = 'client_coach';
    protected $fillable = ['client_id', 'coach_id'];
}
