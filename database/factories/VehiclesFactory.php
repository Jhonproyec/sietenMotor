<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicles>
 */
class VehiclesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'brand' => $this->faker->company,              // Marca del vehículo
            'model' => $this->faker->word,                  // Modelo del vehículo
            'year' => $this->faker->year($max = 'now'),    // Año del vehículo (actual)
            'registration' => strtoupper($this->faker->lexify('??-###-??')), // Registro del vehículo (aleatorio)
            'vin' => $this->faker->bothify('1HGBH41JXMN109186'), // VIN aleatorio
            'no_chasis' => $this->faker->bothify('???######???'), // Número de chasis aleatorio
            'no_motor' => $this->faker->bothify('???#####???'), // Número de motor aleatorio
            'fuel_type' => $this->faker->randomElement(['Gasolina', 'Diesel', 'Eléctrico', 'Híbrido']), // Tipo de combustible
            'id_client' => 1,               // Asigna un cliente aleatorio
            'id_user' => 1,                   // Asigna un usuario aleatorio
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
