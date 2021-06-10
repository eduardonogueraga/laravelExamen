<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function matricula()
    {
        return $this->hasOne(Matricula::class);
    }

    public function newEloquentBuilder($query)
    {
        return new AlumnoQuery($query);
    }



}