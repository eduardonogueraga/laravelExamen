@extends('layout')

@section('title', 'Alumnos')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-3">
        <h1 class="pb-1">{{trans('alumnos.title.index')}}</h1>
        <p>
            <a href="{{route('alumnos.create')}}" class="btn btn-primary">Nuevo alumno</a>
        </p>
    </div>

    @include('alumnos._filters')

    @if ($alumnos->isNotEmpty())

        <div class="table-responsive-lg">
            <table class="table table-sm">
                <thead class="thead-dark">
                <tr>
                    <th scope="col"># <span class="oi oi-caret-bottom"></span><span class="oi oi-caret-top"></span></th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellidos</th>
                    <th scope="col">NIF</th>
                    <th scope="col">Validado</th>
                    <th scope="col">Repetidor</th>
                    <th scope="col">Fecha</th>
                    <th scope="col" class="text-right th-actions">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @each('alumnos._row', $alumnos, 'alumno')
                </tbody>
            </table>
            {{ $alumnos->links() }}
        </div>
    @else
        <p>No hay alumnos para listar</p>
    @endif
@endsection


