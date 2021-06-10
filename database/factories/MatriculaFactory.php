<?php

namespace Database\Factories;

use App\Matricula;
use Illuminate\Database\Eloquent\Factories\Factory;

class MatriculaFactory extends Factory
{
    protected $model = Matricula::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'validado' => rand(0,1),
            'repetidor' => rand(0,1)
        ];
    }
}
