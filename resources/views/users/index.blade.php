@extends('layout')

@section('title')
    Curso Laravel
@endsection

@section('content')
<h1>{{ $title }}</h1>

<ul>
    @forelse($users as $user)
        <li>{{ $user->name }} ({{ $user->email }})</li>
        <a href="{{ route('users.show', $user->id) }}">Ver detalles</a>
    @empty
        <p>No hay usuarios registrados</p>
    @endforelse
</ul>
@endsection
