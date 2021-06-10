<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function cursos()
    {
        return $this->hasMany(Curso::class);
    }

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

}