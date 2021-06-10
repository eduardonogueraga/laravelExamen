<?php

namespace Tests\Feature\Admin;

use App\Alumno;
use App\Curso;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FilterAlumnosTest extends TestCase
{
    use RefreshDatabase;

    /** @test  */
    function it_loads_the_alumno_list_page_with_filters(){
      $this->get(route('alumnos.index'))
            ->assertStatus(200)
            ->assertSee('Listado de alumnos')
            ->assertSee(trans('alumnos.filters.valid'));
        
    }

    /** @test */
    function filter_alumnos_by_validado()
    {
        $curso =  Curso::create([
            'curso' => '4',
            'nivel' => 'ESO'
        ]);

        $alumnoValidado = Alumno::factory()->create();
        $alumnoSinValidar = Alumno::factory()->create();

        $alumnoValidado->matricula()->create([
            'curso_id' => $curso->id,
            'created_at' => now(),
            'validado'=> 1,
            'repetidor'=> 0,
        ]);

        $alumnoSinValidar->matricula()->create([
            'curso_id' => $curso->id,
            'created_at' => now(),
            'validado'=> 0,
            'repetidor'=> 0,
        ]);


        $response = $this->get('alumnos?valido=with')
            ->assertStatus(200);

        $response->assertViewCollection('alumnos')
            ->contains($alumnoValidado)
            ->notContains($alumnoSinValidar);
    }

    /** @test */
    public function filter_alumnos_by_created_at()
    {
        $today = now()->format('d/m/Y');
        $twoMonthsBefore = now()->addDays(60)->format('d/m/Y');
        $twoMonthsAfter = now()->subDays(60)->format('d/m/Y');

        $newAlumno = Alumno::factory()->create([
            'created_at' => now()->addDays(3),
        ]);

        $oldAlumno = Alumno::factory()->create([
            'created_at' => now()->addDay(30)
        ]);

        $this->get("alumnos?from={$today}&to={$twoMonthsBefore}")
            ->assertStatus(200)
            ->assertViewCollection('alumnos')
            ->contains($newAlumno)
            ->contains($oldAlumno);


        $this->get("alumnos?from={$twoMonthsAfter}&to={$today}")
            ->assertStatus(200)
            ->assertViewCollection('alumnos')
            ->notContains($newAlumno)
            ->notContains($oldAlumno);
    }


}