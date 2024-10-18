<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */


     protected $model = Room::class;

    public function definition()
    {
        return [
            'country' => $this->faker->country,
            'capacity' => 50,
            'current_size' => $this->faker->numberBetween(1, 50),
            'total_score' => $this->faker->numberBetween(0, 1000),
            'event_id' => Event::factory(), // Automatically create an event if needed
        ];
    }

    }
