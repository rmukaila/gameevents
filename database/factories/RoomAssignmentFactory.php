<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Player;
use App\Models\Room;
use App\Models\RoomAssignment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RoomAssignment>
 */
class RoomAssignmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = RoomAssignment::class;

    public function definition()
    {
        return [
            'player_id' => Player::factory(), // Automatically create a player if needed
            'room_id' => Room::factory(), // Automatically create a room if needed
            'event_id' => Event::factory(), // Automatically create an event if needed
            'score' => $this->faker->numberBetween(0, 100), // Player's score
        ];
    }
}
