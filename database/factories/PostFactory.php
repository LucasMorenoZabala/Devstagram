<?php

//son una herramienta extremadamente útil para generar datos de prueba. 
//Los factories hacen que sea fácil generar grandes cantidades de datos de prueba de manera coherente y bien estructurada, 
//lo que puede ahorrar tiempo y esfuerzo en el proceso de desarrollo.

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        //faker es una libreria para simular datos. Para no tener que enviar el formulario cada 2x3 y que sea todo mas rapido
        return [
            'titulo' => $this->faker->sentence(5),
            'descripcion' => $this->faker->sentence(20),
            'imagen' => $this->faker->uuid() . '.jpg',
            'user_id' => $this->faker->randomElement([8, 9, 10])
        ];
    }
}
