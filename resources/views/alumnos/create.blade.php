@extends('layout')

@section('title', 'Nuevo alumno')

@section('content')
    @card
    @slot('header', 'Crear nuevo alumno')
    @include('shared._errors')

    <form method="post" action="{{ route('alumnos.store') }}">
        @include('alumnos._fields')

        <div class="form-group mt-4">
            <button type="submit" class="btn btn-primary">Crear el nuevo alumno</button>
            <a href="{{ route('alumnos.index') }}" class="btn btn-link">Regresar al listado de alumnos</a>
        </div>
    </form>
    @endcard
@endsection
