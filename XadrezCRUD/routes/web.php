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
    return view('welcome');
});

Route::get('/usuarios', 'Usuarios@index');

Route::get('/usuarios_form/{user}','Usuarios@pegarForm');
Route::post('/usuarios_form/{user}','Usuarios@enviarForm');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
