<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipo>
 */
class EquipoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            // nombre (maximo 30), pais, jugadorestrella,puntaje (numerico)
            'nombre' => $this->faker->name,
            'pais' => $this->faker->country,
            'jugadorestrella' => $this->faker->name,
            'puntaje' => $this->faker->numberBetween(0, 100),   
            
        ];
    }
}
