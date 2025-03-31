<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->numerify('6########'), // Número de teléfono español
            'address' => $this->faker->optional()->streetAddress(),
            'province' => $this->faker->optional()->state(),
            'city' => $this->faker->optional()->city(),
            'id_user' => 1, 
        ];
    }
}
