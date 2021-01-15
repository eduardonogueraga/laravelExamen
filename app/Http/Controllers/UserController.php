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
        return 'Creando un usuario nuevo';
    }

    public function show($id)
    {
        $user = User::find($id);

        return view('users.show', compact('user'));
    }
}
