<?php

namespace Database\Seeders;

use App\Alumno;
use App\Curso;
use App\Matricula;
use Illuminate\Database\Seeder;

class MatriculaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected $cursos;
    protected $alumnos;

    public function run()
    {
        $this->cursos = Curso::inRandomOrder()->pluck('id');
        $this->alumnos = Alumno::all();

        foreach ($this->alumnos as $alumno){

            Matricula::factory()->create([
                'alumno_id' => $alumno->id,
                'curso_id' => $this->cursos->random(),
                'created_at' => $alumno->created_at

            ]);
        }

    }
}
