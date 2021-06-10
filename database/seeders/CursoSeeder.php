<?php

namespace Database\Seeders;

use App\Curso;
use Illuminate\Database\Seeder;

class CursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Curso::create([
            'curso' => '1',
            'nivel' => 'ESO'
        ]);

        Curso::create([
            'curso' => '2',
            'nivel' => 'ESO'
        ]);

        Curso::create([
            'curso' => '3',
            'nivel' => 'ESO'
        ]);

        Curso::create([
            'curso' => '4',
            'nivel' => 'ESO'
        ]);

        Curso::create([
            'curso' => '1',
            'nivel' => 'Bachillerato'
        ]);

        Curso::create([
            'curso' => '2',
            'nivel' => 'Bachillerato'
        ]);
    }


}
