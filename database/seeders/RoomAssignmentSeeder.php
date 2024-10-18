<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\Room;
use App\Models\RoomAssignment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = Room::all();

        foreach ($rooms as $room) {
            $players = Player::inRandomOrder()->limit(5)->get(); // Assign 5 random players to each room

            foreach ($players as $player) {
                RoomAssignment::create([
                    'player_id' => $player->id,
                    'room_id' => $room->id,
                    'event_id' => $room->event_id,
                    'score' => rand(0, 100), // Random score between 0 and 100
                ]);
            }
        }
    }
}
