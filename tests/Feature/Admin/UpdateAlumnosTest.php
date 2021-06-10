<?php

namespace Tests\Feature\Admin;

use App\Alumno;
use App\Curso;
use App\Matricula;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateAlumnosTest extends TestCase
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
    function it_loads_the_edit_alumno_page()
    {
        $curso = Curso::create([
            'curso' => '4',
            'nivel' => 'ESO'
        ]);

        $alumno = Alumno::factory()->create();

        $this->get(route('alumnos.edit', ['alumno' => $alumno]))
            ->assertStatus(200)
            ->assertViewIs('alumnos.edit')
            ->assertSee('Editar alumno')
            ->assertViewHas('cursos', function ($cursos) use ($curso) {
                return $cursos->contains($curso);
            });
    }


    /** @test  */
    function its_can_update_a_alumno()
    {

        $curso =  Curso::create([
            'curso' => '4',
            'nivel' => 'ESO'
        ]);

        $alumno = Alumno::factory()->create();

        $alumno->matricula()->create([
            'alumno_id' => $alumno->id,
            'curso_id' => $curso->id,
            'created_at' => now(),
            'validado'=> 0,
            'repetidor'=> 0,
        ]);



        $this->from(route('alumnos.edit', ['alumno' => $alumno]))
            ->put(route('alumnos.update', ['alumno' => $alumno]), $this->withData([
                'curso' => $curso->id
            ]))
            ->assertRedirect(route('alumnos.index'));

        $this->assertDatabaseHas('alumnos', [
            'nombre' => 'Antonio',
            'apellidos' => 'Perez',
            'nif' => '1234567z',
            'domicilio' => 'Su casa',
            'cp' => '1234',
        ]);

        $this->assertDatabaseHas('matriculas',[
            'alumno_id' => $alumno->id,
            'curso_id' => $curso->id,
        ]);

    }

    /** @test */
    function the_nombre_field_is_required()
    {
        $curso =  Curso::create([
            'curso' => '4',
            'nivel' => 'ESO'
        ]);

        $alumno = Alumno::factory()->create();

        $alumno->matricula()->create([
            'alumno_id' => $alumno->id,
            'curso_id' => $curso->id,
            'created_at' => now(),
            'validado'=> 0,
            'repetidor'=> 0,
        ]);

        $alumno = Alumno::factory()->create(['nombre' => 'Pepe',]);

        $this->handleValidationExceptions();

        $this->from(route('alumnos.edit', ['alumno' => $alumno]))
            ->put(route('alumnos.update', ['alumno' => $alumno]), [
                'nombre' => null,
            ])->assertSessionHasErrors(['nombre'])
            ->assertRedirect(url()->previous());

        $this->assertDatabaseHas('alumnos',[
            'nombre' => 'Pepe',
        ]);


    }


    /** @test */
    function the_apellidos_field_is_required()
    {

        $curso =  Curso::create([
            'curso' => '4',
            'nivel' => 'ESO'
        ]);

        $alumno = Alumno::factory()->create();

        $alumno->matricula()->create([
            'alumno_id' => $alumno->id,
            'curso_id' => $curso->id,
            'created_at' => now(),
            'validado'=> 0,
            'repetidor'=> 0,
        ]);

        $alumno = Alumno::factory()->create(['apellidos' => 'Perez',]);

        $this->handleValidationExceptions();

        $this->from(route('alumnos.edit', ['alumno' => $alumno]))
            ->put(route('alumnos.update', ['alumno' => $alumno]), [
                'apellidos' => null,
            ])->assertSessionHasErrors(['apellidos'])
            ->assertRedirect(url()->previous());

        $this->assertDatabaseHas('alumnos',[
            'apellidos' => 'Perez',
        ]);
    }


    /** @test */
    function the_nif_field_is_required()
    {
        $curso =  Curso::create([
            'curso' => '4',
            'nivel' => 'ESO'
        ]);

        $alumno = Alumno::factory()->create();

        $alumno->matricula()->create([
            'alumno_id' => $alumno->id,
            'curso_id' => $curso->id,
            'created_at' => now(),
            'validado'=> 0,
            'repetidor'=> 0,
        ]);

        $alumno = Alumno::factory()->create(['nif' => '1234567Z',]);

        $this->handleValidationExceptions();

        $this->from(route('alumnos.edit', ['alumno' => $alumno]))
            ->put(route('alumnos.update', ['alumno' => $alumno]), [
                'nif' => null,
            ])->assertSessionHasErrors(['nif'])
            ->assertRedirect(url()->previous());

        $this->assertDatabaseHas('alumnos',[
            'nif' => '1234567Z',
        ]);
    }

    /** @test */
    function the_domicilio_field_is_required()
    {
        $curso =  Curso::create([
            'curso' => '4',
            'nivel' => 'ESO'
        ]);

        $alumno = Alumno::factory()->create();

        $alumno->matricula()->create([
            'alumno_id' => $alumno->id,
            'curso_id' => $curso->id,
            'created_at' => now(),
            'validado'=> 0,
            'repetidor'=> 0,
        ]);

        $alumno = Alumno::factory()->create(['domicilio' => 'Mi casa',]);

        $this->handleValidationExceptions();

        $this->from(route('alumnos.edit', ['alumno' => $alumno]))
            ->put(route('alumnos.update', ['alumno' => $alumno]), [
                'domicilio' => null,
            ])->assertSessionHasErrors(['domicilio'])
            ->assertRedirect(url()->previous());

        $this->assertDatabaseHas('alumnos',[
            'domicilio' => 'Mi casa',
        ]);
    }

    /** @test */
    function the_cp_field_is_required()
    {

        $curso =  Curso::create([
            'curso' => '4',
            'nivel' => 'ESO'
        ]);

        $alumno = Alumno::factory()->create();

        $alumno->matricula()->create([
            'alumno_id' => $alumno->id,
            'curso_id' => $curso->id,
            'created_at' => now(),
            'validado'=> 0,
            'repetidor'=> 0,
        ]);

        $alumno = Alumno::factory()->create(['cp' => '1234',]);

        $this->handleValidationExceptions();

        $this->from(route('alumnos.edit', ['alumno' => $alumno]))
            ->put(route('alumnos.update', ['alumno' => $alumno]), [
                'domicilio' => null,
            ])->assertSessionHasErrors(['cp'])
            ->assertRedirect(url()->previous());

        $this->assertDatabaseHas('alumnos',[
            'cp' => '1234',
        ]);
    }


    /** @test */
    function the_curso_field_is_required()
    {
        $curso = Curso::create([
            'curso' => '1',
            'nivel' => 'Bachillerato'
        ]);

        $alumno = Alumno::factory()->create();

        $alumno->matricula()->create([
            'alumno_id' => $alumno->id,
            'curso_id' => $curso->id,
            'created_at' => now(),
            'validado'=> 0,
            'repetidor'=> 0,
        ]);

        $this->handleValidationExceptions();

        $this->from(route('alumnos.edit', ['alumno' => $alumno]))
            ->put(route('alumnos.update', ['alumno' => $alumno]), [
                'curso' => null,
            ])->assertSessionHasErrors(['domicilio'])
            ->assertRedirect(url()->previous());

        $this->assertDatabaseHas('alumnos',[
            'nombre' => $alumno->nombre,
        ]);

        $this->assertDatabaseHas('matriculas',[
            'alumno_id' => $alumno->id,
            'curso_id' => $curso->id,
        ]);
    }

    /** @test  */
    function the_nombre_field_must_be_valid()
    {
        $curso =  Curso::create([
            'curso' => '4',
            'nivel' => 'ESO'
        ]);

        $alumno = Alumno::factory()->create();

        $alumno->matricula()->create([
            'alumno_id' => $alumno->id,
            'curso_id' => $curso->id,
            'created_at' => now(),
            'validado'=> 0,
            'repetidor'=> 0,
        ]);

        $this->handleValidationExceptions();

        $alumno = Alumno::factory()->create(['nombre' => 'Pepe',]);


        $this->from(route('alumnos.edit', ['alumno' => $alumno]))
            ->put(route('alumnos.update', ['alumno' => $alumno]), [
                'nombre' => 'Invalid|@#~€¬',
            ])->assertSessionHasErrors(['nombre'])
            ->assertRedirect(url()->previous());

        $this->assertDatabaseHas('alumnos',[
            'nombre' => 'Pepe',
        ]);
    }

    /** @test  */
    function the_apellidos_field_must_be_valid()
    {
        $curso =  Curso::create([
            'curso' => '4',
            'nivel' => 'ESO'
        ]);

        $alumno = Alumno::factory()->create();

        $alumno->matricula()->create([
            'alumno_id' => $alumno->id,
            'curso_id' => $curso->id,
            'created_at' => now(),
            'validado'=> 0,
            'repetidor'=> 0,
        ]);

        $this->handleValidationExceptions();

        $alumno = Alumno::factory()->create(['apellidos' => 'Perez',]);


        $this->from(route('alumnos.edit', ['alumno' => $alumno]))
            ->put(route('alumnos.update', ['alumno' => $alumno]), [
                'apellidos' => 'Invalid|@#~€¬',
            ])->assertSessionHasErrors(['apellidos'])
            ->assertRedirect(url()->previous());

        $this->assertDatabaseHas('alumnos',[
            'apellidos' => 'Perez',
        ]);
    }


    /** @test  */
    function the_nif_field_must_be_numeric()
    {
        $curso =  Curso::create([
            'curso' => '4',
            'nivel' => 'ESO'
        ]);

        $alumno = Alumno::factory()->create();

        $alumno->matricula()->create([
            'alumno_id' => $alumno->id,
            'curso_id' => $curso->id,
            'created_at' => now(),
            'validado'=> 0,
            'repetidor'=> 0,
        ]);

        $this->handleValidationExceptions();

        $alumno = Alumno::factory()->create(['nif' => '1234567Z',]);


        $this->from(route('alumnos.edit', ['alumno' => $alumno]))
            ->put(route('alumnos.update', ['alumno' => $alumno]), [
                'nif' => 'String',
            ])->assertSessionHasErrors(['nif'])
            ->assertRedirect(url()->previous());

        $this->assertDatabaseHas('alumnos',[
            'nif' => '1234567Z',
        ]);
    }



    /** @test  */
    function the_cp_field_must_be_numeric()
    {
        $curso =  Curso::create([
            'curso' => '4',
            'nivel' => 'ESO'
        ]);

        $alumno = Alumno::factory()->create();

        $alumno->matricula()->create([
            'alumno_id' => $alumno->id,
            'curso_id' => $curso->id,
            'created_at' => now(),
            'validado'=> 0,
            'repetidor'=> 0,
        ]);

        $this->handleValidationExceptions();

        $alumno = Alumno::factory()->create(['cp' => '1234',]);


        $this->from(route('alumnos.edit', ['alumno' => $alumno]))
            ->put(route('alumnos.update', ['alumno' => $alumno]), [
                'domicilio' => 'UnoDos',
            ])->assertSessionHasErrors(['cp'])
            ->assertRedirect(url()->previous());

        $this->assertDatabaseHas('alumnos',[
            'cp' => '1234',
        ]);
    }

    /** @test  */
    function the_curso_field_must_exist_in_cursos()
    {
        $curso = Curso::create([
            'curso' => '1',
            'nivel' => 'Bachillerato'
        ]);

        $alumno = Alumno::factory()->create();

        $alumno->matricula()->create([
            'alumno_id' => $alumno->id,
            'curso_id' => $curso->id,
            'created_at' => now(),
            'validado'=> 0,
            'repetidor'=> 0,
        ]);

        $this->handleValidationExceptions();

        $this->from(route('alumnos.edit', ['alumno' => $alumno]))
            ->put(route('alumnos.update', ['alumno' => $alumno]), [
                'curso' => $curso->id+999
            ])->assertSessionHasErrors(['domicilio'])
            ->assertRedirect(url()->previous());

        $this->assertDatabaseHas('alumnos',[
            'nombre' => $alumno->nombre,
        ]);

        $this->assertDatabaseHas('matriculas',[
            'alumno_id' => $alumno->id,
            'curso_id' => $curso->id,
        ]);
    }

  
}