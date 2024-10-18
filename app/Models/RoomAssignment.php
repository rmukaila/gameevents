<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomAssignment extends Model
{
    protected $fillable = ['player_id', 'room_id', 'event_id', 'score'];

    // Define the relationships

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
