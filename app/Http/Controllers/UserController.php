<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = [
            'Joel',
            'Ellie',
            'Tess',
            'Tommy',
            'Bill',
            '<script>alert("Click aquí")</script>',
        ];
        $title = 'Listado de usuarios';
        return view('users')->with(['users' => $users, 'title' => $title]);
    }

    public function create()
    {
        return 'Creando un usuario nuevo';
    }

    public function show($id)
    {
        return 'Mostrando detalles del usuario: ' . $id;
    }
}
