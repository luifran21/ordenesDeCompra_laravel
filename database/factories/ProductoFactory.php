<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->domainName(),
            'precio' => fake()->randomFloat(2,1,10),
            'unidades_de_medida' => "unidad",
            'descripcion' => fake()->paragraph(),
        ];
    }
}
