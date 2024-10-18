<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\EventLog;
use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventLog>
 */
class EventLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = EventLog::class;

    public function definition()
    {
        return [
            'player_id' => Player::factory(), // Automatically create a player if needed
            'event_id' => Event::factory(), // Automatically create an event if needed
            'action' => $this->faker->randomElement(['completed_level', 'joined_room']),
            'details' => $this->faker->sentence,
        ];
    }
}
