<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['country', 'capacity', 'current_size', 'total_score', 'event_id'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function players()
    {
        return $this->belongsToMany(Player::class);
    }
}
