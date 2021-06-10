<?php

namespace Tests\Feature\Admin;

use App\Alumno;
use App\Curso;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchAlumnoTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function search_by_alumno_nombre()
    {
        Alumno::factory()->create(['nombre' => 'Alena']);
        Alumno::factory()->create(['nombre' => 'Jesus']);

        $this->get(route('alumnos.index', ['search' => 'Jesus']))
            ->assertOk()
            ->assertSee('Jesus')
            ->assertDontSee('Alena');

    }

    /** @test */
    public function partial_search_by_nombre()
    {
        Alumno::factory()->create(['nombre' => 'Pedro']);
        Alumno::factory()->create(['nombre' => 'Ana']);
        Alumno::factory()->create(['nombre' => 'Antonio']);

       $this->get('alumnos?search=An')
            ->assertOk()
            ->assertSee('Ana')
            ->assertDontSee('Pedro');
    }


    /** @test */
    public function search_by_alumno_apellidos()
    {
        Alumno::factory()->create(['nombre' => 'Alena', 'apellidos' => 'Perez Lopez']);
        Alumno::factory()->create(['nombre' => 'Jesus', 'apellidos' => 'Martinez Garcia']);

        $this->get(route('alumnos.index', ['search' => 'Martinez']))
            ->assertOk()
            ->assertSee('Jesus')
            ->assertDontSee('Alena');

    }

    /** @test */
    public function partial_search_by_alumno_apellidos()
    {
        Alumno::factory()->create(['nombre' => 'Alena', 'apellidos' => 'Montoya Lopez']);
        Alumno::factory()->create(['nombre' => 'Jesus', 'apellidos' => 'Montalban Garcia']);

        $this->get(route('alumnos.index', ['search' => 'Monto']))
            ->assertOk()
            ->assertSee('Alena')
            ->assertDontSee('Jseus');

    }

}