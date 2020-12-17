<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return 'Hola Mundo !!!';
});

Route::get('/usuarios', function () {
    return 'Usuarios';
});

/*Route::get('/usuarios/detalles', function () {
    return 'Mostrando detalles del usuario: ' . $_GET['id'];
});*/

Route::get('usuarios/nuevo', function () {
    return 'Creando un usuario nuevo';
});

Route::get('usuarios/{id}', function ($id) {
    return 'Mostrando detalles del usuario: ' . $id;
})->where('id', '[0-9]+');

Route::get('/saludo/{name}/{nickname?}', function ($name, $nickname = null) {
    if ($nickname) {
        return 'Bienvenido ' . ucfirst($name) . '. Tu apodo es ' . $nickname;
    } else {
        return 'Bienvenido ' . ucfirst($name) . '.';
    }
});



