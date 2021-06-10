<?php

namespace Tests\Feature\Admin;

use App\Alumno;
use App\Curso;
use App\Matricula;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateAlumnosTest extends TestCase
{
    use RefreshDatabase;


    protected $defaultData = [
        'nombre' => 'Antonio',
        'apellidos' => 'Perez',
        'nif' => '1234567z',
        'domicilio' => 'Su casa',
        'cp' => '1234',
        'curso' => '',
    ];

    /** @test */
    function it_loads_the_new_alumno_page()
    {
       $curso =  Curso::create([
            'curso' => '4',
            'nivel' => 'ESO'
        ]);

        $this->get(route('alumnos.create'))
            ->assertStatus(200)
            ->assertSee('Crear nuevo alumno')
            ->assertViewHas('cursos', function ($cursos) use ($curso) {
                return $cursos->contains($curso);
            });
    }

    /** @test */
    function its_creates_a_new_alumno()
    {

        $curso =  Curso::create([
            'curso' => '4',
            'nivel' => 'ESO'
        ]);

        $this->from(route('alumnos.create'))
            ->post(route('alumnos.store'), $this->withData([
              'curso' => $curso->id
            ]))->assertRedirect(route('alumnos.index'));

        $this->assertDatabaseCount('alumnos', 1);

        $this->assertDatabaseHas('alumnos', [
            'nombre' => 'Antonio',
            'apellidos' => 'Perez',
            'nif' => '1234567z',
            'domicilio' => 'Su casa',
            'cp' => '1234',
        ]);

        $alumno = Alumno::whereNombre('Antonio')->first()->id;

        $this->assertDatabaseHas('matriculas',[
            'alumno_id' => $alumno,
            'curso_id' => $curso->id,
        ]);

    }

    /** @test */
    function the_nombre_field_is_required()
    {
        $this->handleValidationExceptions();

        $this->from(route('alumnos.create'))
            ->post(route('alumnos.store'), [
                'nombre' => null,
            ])->assertSessionHasErrors(['nombre'])
            ->assertRedirect(url()->previous());

        $this->assertDatabaseEmpty('alumnos');

        $this->assertDatabaseEmpty('matriculas');
    }


    /** @test */
    function the_apellidos_field_is_required()
    {
        $this->handleValidationExceptions();

        $this->from(route('alumnos.create'))
            ->post(route('alumnos.store'), [
                'apellidos' => null,
            ])->assertSessionHasErrors(['apellidos'])
            ->assertRedirect(url()->previous());

        $this->assertDatabaseEmpty('alumnos');
        $this->assertDatabaseEmpty('matriculas');
    }


    /** @test */
    function the_nif_field_is_required()
    {
        $this->handleValidationExceptions();

        $this->from(route('alumnos.create'))
            ->post(route('alumnos.store'), [
                'nif' => null,
            ])->assertSessionHasErrors(['nif'])
            ->assertRedirect(url()->previous());

        $this->assertDatabaseEmpty('alumnos');
        $this->assertDatabaseEmpty('matriculas');
    }

    /** @test */
    function the_domicilio_field_is_required()
    {
        $this->handleValidationExceptions();

        $this->from(route('alumnos.create'))
            ->post(route('alumnos.store'), [
                'domicilio' => null,
            ])->assertSessionHasErrors(['domicilio'])
            ->assertRedirect(url()->previous());

        $this->assertDatabaseEmpty('alumnos');
        $this->assertDatabaseEmpty('matriculas');
    }

    /** @test */
    function the_cp_field_is_required()
    {
        $this->handleValidationExceptions();

        $this->from(route('alumnos.create'))
            ->post(route('alumnos.store'), [
                'cp' => null,
            ])->assertSessionHasErrors(['cp'])
            ->assertRedirect(url()->previous());

        $this->assertDatabaseEmpty('alumnos');
        $this->assertDatabaseEmpty('matriculas');
    }


    /** @test */
    function the_curso_field_is_required()
    {
        $this->handleValidationExceptions();

        $this->from(route('alumnos.create'))
            ->post(route('alumnos.store'), [
                'curso' => null,
            ])->assertSessionHasErrors(['curso'])
            ->assertRedirect(url()->previous());

        $this->assertDatabaseEmpty('alumnos');
        $this->assertDatabaseEmpty('matriculas');
    }
    

    /** @test */
    function the_nombre_field_must_be_valid()
    {
        $this->handleValidationExceptions();

        $this->from(route('alumnos.create'))
            ->post(route('alumnos.store'), [
                'nombre' => 'Invalid@#@~€',
            ])->assertSessionHasErrors(['nombre'])
            ->assertRedirect(url()->previous());

        $this->assertDatabaseEmpty('alumnos');
        $this->assertDatabaseEmpty('matriculas');
    }

    /** @test */
    function the_apellidos_field_must_be_valid()
    {
        $this->handleValidationExceptions();

        $this->from(route('alumnos.create'))
            ->post(route('alumnos.store'), [
                'apellidos' => 'Invalid@#@~€',
            ])->assertSessionHasErrors(['apellidos'])
            ->assertRedirect(url()->previous());

        $this->assertDatabaseEmpty('alumnos');
        $this->assertDatabaseEmpty('matriculas');
    }

    /** @test */
    function the_nif_field_must_be_valid()
    {
        $this->handleValidationExceptions();

        $this->from(route('alumnos.create'))
            ->post(route('alumnos.store'), [
                'nif' => Str::random(30),
            ])->assertSessionHasErrors(['nif'])
            ->assertRedirect(url()->previous());

        $this->assertDatabaseEmpty('alumnos');
        $this->assertDatabaseEmpty('matriculas');
    }


    /** @test */
    function the_cp_field_must_be_numeric()
    {
        $this->handleValidationExceptions();

        $this->from(route('alumnos.create'))
            ->post(route('alumnos.store'), [
                'cp' => 'String',
            ])->assertSessionHasErrors(['cp'])
            ->assertRedirect(url()->previous());

        $this->assertDatabaseEmpty('alumnos');
        $this->assertDatabaseEmpty('matriculas');
    }

    /** @test */
    function the_curso_field_must_be_exists_in_cursos()
    {

        $curso =  Curso::create([
            'curso' => '4',
            'nivel' => 'ESO'
        ]);

        $this->handleValidationExceptions();

        $this->from(route('alumnos.create'))
            ->post(route('alumnos.store'), [
                'curso' => $curso->id+999
            ])->assertSessionHasErrors(['curso'])
            ->assertRedirect(url()->previous());

        $this->assertDatabaseEmpty('alumnos');
        $this->assertDatabaseEmpty('matriculas');
    }
    
  
}