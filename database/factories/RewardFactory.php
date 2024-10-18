<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Player;
use App\Models\Reward;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reward>
 */
class RewardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = Reward::class;

    public function definition()
    {
        return [
            'rank' => $this->faker->numberBetween(1, 10),
            'reward' => $this->faker->numberBetween(20, 100),
            'room_id' => Room::factory(), // Automatically create a room if needed
            'player_id' => Player::factory(), // Automatically create a player if needed
            'event_id' => Event::factory(), // Automatically create an event if needed
        ];
    }

    }
