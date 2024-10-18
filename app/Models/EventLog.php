<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventLog extends Model
{
    use HasFactory;
    protected $fillable = ['player_id', 'event_id', 'action', 'details'];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
