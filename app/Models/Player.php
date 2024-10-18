<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = ['name', 'country'];

    public function rooms()
    {
        return $this->belongsToMany(Room::class);
    }

    public function rewards()
    {
        return $this->hasMany(Reward::class);
    }

    public function eventLogs()
    {
        return $this->hasMany(EventLog::class);
    }
}
