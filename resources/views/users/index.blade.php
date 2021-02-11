@extends('layout')

@section('title')
    Curso Laravel
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-3 mt-5">
        <h1 class="pb-1">{{ $title }}</h1>
        <p>
            <a href="{{ route('users.create') }}" class="btn btn-primary">Nuevo usuario</a>
        </p>
    </div>

@if ($users->isNotEmpty())
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Nombre</th>
            <th scope="col">Correo</th>
            <th scope="col">Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <th scope="row">{{ $user->id }}</th>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td class="form-inline">
                @if($user->trashed())
                    <form action="{{ route('users.destroy', $user) }}" method="post">
                        @csrf @method('delete')
                        <button type="submit" class="btn btn-link"><span class="oi oi-circle-x"></span></button>
                    </form>
                @else
                    <a href="{{ route('users.show', $user) }}" class="btn btn-link"><span class="oi oi-eye"></span></a>
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-link"><span class="oi oi-pencil"></span></a>
                    <form action="{{ route('users.trash', $user) }}" method="post">
                        @csrf @method('patch')
                        <button type="submit" class="btn btn-link"><span class="oi oi-trash"></span></button>
                    </form>
                @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <p>No hay usuarios registrados</p>
@endif
@endsection
