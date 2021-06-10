@extends('layout')

@section('title', 'Editar alumno')

@section('content')
    @card
    @slot('header', 'Editar alumno')
    @include('shared._errors')

    <form method="post" action="{{ route('alumnos.update', $alumno) }}">
        {{ method_field('PUT') }}
        @include('alumnos._fields')

        <div class="form-group mt-4">
            <button type="submit" class="btn btn-primary">Actualizar alumno</button>
            <a href="{{ route('alumnos.index') }}" class="btn btn-link">Regresar al listado de alumnos</a>
        </div>
    </form>
    @endcard
@endsection
