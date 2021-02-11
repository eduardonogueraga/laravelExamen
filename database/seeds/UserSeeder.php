<?php

use App\{User, Profession};
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $professionId = Profession::whereTitle('Desarrollador Back-End')->value('id');

        $user = factory(User::class)->create([
            'name' => 'Pepe Pérez',
            'email' => 'pepe@mail.es',
            'password' => bcrypt('123456'),
            'role' => 'admin',
        ]);

        $user->profile()->create([
            'bio' => 'Programador',
            'profession_id' =>  $professionId,
        ]);

        factory(User::class, 999)->create()->each(function ($user) {
            $user->profile()->create(
                factory(\App\UserProfile::class)->raw()
            );
        });
    }
}
