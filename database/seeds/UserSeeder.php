<?php

use App\{User, Profession, Skill, Team, UserProfile};
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    private $professions;
    private $skills;
    private $teams;

    public function run()
    {
        $this->fetchRelations();

        $this->createAdmin();

        foreach (range(1,999) as $i) {
            $this->createRandomUser();
        }
    }

    public function fetchRelations()
    {
        $this->professions = Profession::all();
        $this->skills = Skill::all();
        $this->teams = Team::all();
    }

    public function createAdmin()
    {
        $admin = factory(User::class)->create([
            'team_id' => $this->teams->firstWhere('name', 'IES Ingeniero')->id,
            'first_name' => 'Pepe',
            'last_name' => 'Pérez',
            'email' => 'pepe@mail.es',
            'password' => bcrypt('123456'),
            'role' => 'admin',
            'created_at' => now()->addDay(),
            'active' => true,
        ]);

        $admin->skills()->attach($this->skills);

        $admin->profile()->create([
            'bio' => 'Programador',
            'profession_id' => $this->professions->where('title', 'Desarrollador Back-End')->first()->id,
        ]);
    }

    public function createRandomUser()
    {
        $user = factory(User::class)->create([
            'team_id' => rand(0, 2) ? null : $this->teams->random()->id,
            'active' => rand(0,4) ? true : false,
        ]);

        $user->skills()->attach($this->skills->random(rand(0, 7)));

        $user->profile()->create(
            factory(UserProfile::class)->raw([
                'profession_id' => rand(0, 2) ? $this->professions->random()->id : null,
            ])
        );
    }
}
