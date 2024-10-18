<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Event::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence(3),
            'start_date' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'end_date' => $this->faker->dateTimeBetween('now', '+1 week'),
            'is_active' => $this->faker->boolean,
        ];
    }
    }
