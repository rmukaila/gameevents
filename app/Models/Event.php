<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['name', 'start_date', 'end_date', 'is_active'];

    // public function rooms()
    // {
    //     return $this->hasMany(Room::class);
    // }

    // public function rewards()
    // {
    //     return $this->hasMany(Reward::class);
    // }

    // public function eventLogs()
    // {
    //     return $this->hasMany(EventLog::class);
    // }
}
