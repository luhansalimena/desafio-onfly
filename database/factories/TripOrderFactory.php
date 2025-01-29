<?php

namespace Database\Factories;

use App\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TripOrder>
 */
class TripOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => $this->faker->randomElement(array_column(OrderStatus::cases(), 'value')),
            'from' => $this->faker->city,
            'to' => $this->faker->city,
            'trip_date' => $this->faker->date(),
            'trip_return_date' => $this->faker->date(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
