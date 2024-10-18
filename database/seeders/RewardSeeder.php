<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\Reward;
use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RewardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = Room::all();
        
        foreach ($rooms as $room) {
            $players = Player::inRandomOrder()->limit(5)->get(); // Select top 10 random players from all players

            foreach ($players as $index => $player) {
                Reward::create([
                    'rank' => $index + 1,
                    'reward' => ($index == 0) ? 100 : ($index == 1 ? 50 : 20),
                    'room_id' => $room->id,
                    'player_id' => $player->id,
                    'event_id' => $room->event_id,
                ]);
            }
        }
    }
}
