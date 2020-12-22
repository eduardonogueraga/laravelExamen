@extends('layout')

@section('content')
<h1>{{ $title }}</h1>

<ul>
    @forelse($users as $user)
        <li>{{ $user }}</li>
    @empty
        <p>No hay usuarios registrados</p>
    @endforelse
</ul>
@endsection
