<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = Event::all();
        
        foreach ($events as $event) {
            Room::factory()->count(5)->create(['event_id' => $event->id]); // Creates 10 rooms for each event
        }
    }
}
