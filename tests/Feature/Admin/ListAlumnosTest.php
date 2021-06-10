<?php

namespace Tests\Feature\Admin;

use App\Alumno;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListAlumnosTest extends TestCase
{
    use RefreshDatabase;




    /** @test */
    function it_shows_the_alumnos_list()
    {
        Alumno::factory()->create(['nombre' => 'Dario']);
        Alumno::factory()->create(['nombre' => 'Pedro']);
        Alumno::factory()->create(['nombre' => 'Antonio']);

        $this->get('/alumnos')
            ->assertStatus(200)
            ->assertSeeInOrder([
                'Antonio',
                'Dario',
                'Pedro'
            ]);

        $this->assertNotRepeatedQueries();
    }

    /** @test  */
    function it_shows_a_default_message_if_the_alumnos_list_is_empty()
    {
        $this->get('alumnos?empty')
            ->assertStatus(200)
            ->assertSee(trans('alumnos.title.index'))
            ->assertSee('No hay alumnos para listar');
    }

    /** @test  */
    function it_paginates_the_alumnos()
    {

        Alumno::factory()->create(['nombre' => 'Antonio']);
        Alumno::factory()->create(['nombre' => 'Dario']);
        Alumno::factory()->times(20)->create();
        Alumno::factory()->create(['nombre' => 'Pedro']);


        $this->get('alumnos')
            ->assertSeeInOrder([
                'Antonio',
                'Dario',
            ])->assertDontSee('Pedro');


        $this->get('alumnos?page=2')
            ->assertSeeInOrder([
                'Pedro',
            ])->assertDontSee('Antonio')
            ->assertDontSee('Dario');
    }

}