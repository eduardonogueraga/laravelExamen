<?php

namespace Database\Seeders;

use App\Alumno;
use App\Curso;
use Illuminate\Database\Seeder;

class AlumnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected $cursos;

    public function run()
    {
        foreach (range(0,500) as $i){
            $this->createRandomAlumno();
        }
    }

    public function createRandomAlumno()
    {
        Alumno::factory()->create([
            'created_at' => now()->subDays(rand(0,60))
        ]);
    }
}
