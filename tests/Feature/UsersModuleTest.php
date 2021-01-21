<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersModuleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_shows_the_users_list()
    {
        factory(User::class)->create([
            'name' => 'Joel',
        ]);

        factory(User::class)->create([
            'name' => 'Ellie',
        ]);

        $this->get('/usuarios')
            ->assertStatus(200)
            ->assertSee('Listado de usuarios')
            ->assertSee('Joel')
            ->assertSee('Ellie');
    }

    /** @test */
    function it_shows_a_default_message_if_the_users_list_is_empty()
    {
        $this->get('/usuarios?empty')
            ->assertStatus(200)
            ->assertSee('Listado de usuarios')
            ->assertSee('No hay usuarios registrados');
    }

    /** @test */
    function it_loads_the_users_details_page()
    {
        $user = factory(User::class)->create([
            'name' => 'José Pérez',
        ]);

        $this->get('/usuarios/'.$user->id)
            ->assertStatus(200)
            ->assertSee($user->name);
    }

    /** @test */
    function it_loads_the_new_users_page()
    {
        $this->get('usuarios/nuevo')
            ->assertStatus(200)
            ->assertSee('Crear nuevo usuario');
    }

    /** @test */
    function it_displays_a_404_error_if_the_user_is_not_found()
    {
        $this->get('usuarios/1000')
            ->assertStatus(404)
            ->assertSee('Página no encontrada');
    }

    /** @test */
    function it_creates_a_new_user()
    {
        $this->post('/usuarios/', [
            'name' => 'Pepe',
            'email' => 'pepe@mail.es',
            'password' => '123456',
        ])->assertRedirect('/usuarios');

        $this->assertCredentials([
            'name' => 'Pepe',
            'email' => 'pepe@mail.es',
            'password' => '123456',
        ]);
    }

    /** @test */
    function the_name_is_required()
    {
        $this->from('/usuarios/nuevo')
            ->post('/usuarios/', [
            'name' => '',
            'email' => 'pepe@mail.es',
            'password' => '123456',
        ])->assertRedirect('/usuarios/nuevo')
            ->assertSessionHasErrors(['name']);

        $this->assertEquals(0, User::count());
    }

    /** @test */
    function the_email_is_required()
    {
        $this->from('/usuarios/nuevo')
            ->post('/usuarios/', [
                'name' => 'Pepe',
                'email' => '',
                'password' => '123456',
            ])->assertRedirect('/usuarios/nuevo')
            ->assertSessionHasErrors(['email']);

        $this->assertEquals(0, User::count());
    }

    /** @test */
    function the_password_is_required()
    {
        $this->from('/usuarios/nuevo')
            ->post('/usuarios/', [
                'name' => 'Pepe',
                'email' => 'pepe@mail.es',
                'password' => '',
            ])->assertRedirect('/usuarios/nuevo')
            ->assertSessionHasErrors(['password']);

        $this->assertEquals(0, User::count());
    }

    /** @test */
    function the_email_must_be_valid()
    {
        $this->from('/usuarios/nuevo')
            ->post('/usuarios/', [
                'name' => 'Pepe',
                'email' => 'correo-no-valido',
                'password' => '123456',
            ])->assertRedirect('/usuarios/nuevo')
            ->assertSessionHasErrors(['email']);

        $this->assertEquals(0, User::count());
    }

    /** @test */
    function the_email_must_be_unique()
    {
        factory(User::class)->create([
            'email' => 'pepe@mail.es',
        ]);

        $this->from('/usuarios/nuevo')
            ->post('/usuarios/', [
                'name' => 'Pepe',
                'email' => 'pepe@mail.es',
                'password' => '123456',
            ])->assertRedirect('/usuarios/nuevo')
            ->assertSessionHasErrors(['email']);

        $this->assertEquals(1, User::count());
    }

    /** @test */
    function it_loads_the_edit_user_page()
    {
        $user = factory(User::class)->create();

        $this->get('/usuarios/'.$user->id.'/editar')
            ->assertStatus(200)
            ->assertViewIs('users.edit')
            ->assertSee('Editar usuario')
            ->assertViewHas('user', function ($viewUser) use ($user) {
                return $viewUser->id === $user->id;
            });
    }

    /** @test */
    function it_updates_a_user()
    {
        //$this->withoutExceptionHandling();
        $user = factory(User::class)->create();

        $this->put('/usuarios/'.$user->id, [
            'name' => 'Pepe',
            'email' => 'pepe@mail.es',
            'password' => '123456',
        ])->assertRedirect('/usuarios/'.$user->id);

        $this->assertCredentials([
            'name' => 'Pepe',
            'email' => 'pepe@mail.es',
            'password' => '123456',
        ]);

    }

}
