<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventLog;
use App\Models\Player;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = Event::all();
        $players = Player::all();

        foreach ($events as $event) {
            foreach ($players as $player) {
                EventLog::create([
                    'player_id' => $player->id,
                    'event_id' => $event->id,
                    'action' => 'completed_level',
                    'details' => 'Player completed a level and earned points.',
                ]);
            }
        }
    }
}
