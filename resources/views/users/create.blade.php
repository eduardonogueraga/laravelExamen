@extends('layout')

@section('title', 'Nuevo usuario')

@section('content')
    <h1>Crear nuevo usuario</h1>

    <form method="post" action="{{ route('users.store') }}">
        {{ csrf_field() }}

        <label for="name">Nombre:</label>
        <input type="text" name="name" placeholder="Nombre">
        <br>
        <label for="email">Correo electrónico:</label>
        <input type="email" name="email" placeholder="Correo electrónico">
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" placeholder="Al menos 6 caracteres">
        <br>
        <button type="submit">Crear usuario</button>
    </form>

    <p>
        <a href="{{ route('users.index') }}">Regresar al listado de usuarios</a>
    </p>
@endsection
