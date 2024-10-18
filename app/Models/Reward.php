<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;
    protected $fillable = ['rank', 'reward', 'room_id', 'player_id', 'event_id'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
