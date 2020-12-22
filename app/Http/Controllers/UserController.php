<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        if (request()->has('empty')) {
            $users = [];
        } else {
            $users = ['Joel', 'Ellie', 'Tess', 'Tommy', 'Bill'];
        }
        $title = 'Listado de usuarios';
        return view('users')->with(['users' => $users, 'title' => $title]);
    }

    public function create()
    {
        return 'Creando un usuario nuevo';
    }

    public function show($id)
    {
        return view('users-show', compact('id'));
    }
}
