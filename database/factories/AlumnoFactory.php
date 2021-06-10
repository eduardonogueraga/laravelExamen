<?php

namespace Database\Factories;

use App\Alumno;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlumnoFactory extends Factory
{
    protected $model = Alumno::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'nombre' => $this->faker->firstName,
            'apellidos' => $this->faker->lastName .' '. $this->faker->lastName,
            'nif' => rand(1000000, 99999999). ''. $this->faker->randomLetter,
            'domicilio' => $this->faker->address,
            'cp' => rand(10000, 99999),
        ];
    }
}
