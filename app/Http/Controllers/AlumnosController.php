<?php

namespace App\Http\Controllers;

use App\Alumno;
use App\Curso;
use App\Http\Requests\CreateAlumnoRequest;
use App\Http\Requests\UpdateAlumnoRequest;
use Illuminate\Http\Request;

class AlumnosController extends Controller
{

    public function index()
    {
        $alumnos = Alumno::query()
            ->with('matricula')
            ->orderBy('nombre')
            ->paginate();

        return view('alumnos.index', [
           'alumnos' => $alumnos,
        ]);
    }


    public function create(Alumno $alumno)
    {
       return view('alumnos.create', [
          'cursos' => Curso::all(),
           'alumno' => $alumno
       ]);
    }


    public function store(CreateAlumnoRequest $request)
    {
       $request->createAlumno();

       return redirect()->route('alumnos.index');
    }


    public function edit(Alumno $alumno)
    {
        return view('alumnos.edit', [
            'cursos' => Curso::all(),
            'alumno' => $alumno
        ]);
    }


    public function update(UpdateAlumnoRequest $request, Alumno $alumno)
    {
        $request->updateAlumno($alumno);

        return redirect()->route('alumnos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Alumno $alumno
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alumno $alumno)
    {
        //
    }
}