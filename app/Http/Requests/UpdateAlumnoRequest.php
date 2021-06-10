<?php

namespace App\Http\Requests;

use App\Alumno;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class UpdateAlumnoRequest extends FormRequest
{
    public function rules()
    {
        return [
            'nombre' => ['required', 'regex:/^[a-zA-ZáéíóúñÑ\s]+$/'],
            'apellidos' => ['required', 'regex:/^[a-zA-ZáéíóúñÑ\s]+$/'],
            'nif' => ['required', 'min:8', 'max:8'],
            'domicilio' => ['required'],
            'cp' => ['required', 'numeric'],
            'curso' => ['required', 'exists:cursos,id'],
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function updateAlumno($alumno)
    {
        DB::transaction(function ()use($alumno){
            $alumno->update([
                'nombre' => $this->nombre,
                'apellidos' => $this->apellidos,
                'nif' => $this->nif,
                'domicilio' => $this->domicilio,
                'cp' => $this->cp,
            ]);

            $alumno->matricula()->update([
                'alumno_id' => $alumno->id,
                'curso_id' => $this->curso,
                'validado' => 0,
                'repetidor' => 0,
            ]);
        });
    }

}