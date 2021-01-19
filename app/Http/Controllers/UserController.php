<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        $title = 'Listado de usuarios';

        return view('users.index', compact('users', 'title'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store()
    {
        return 'Procesando información...';
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
}
