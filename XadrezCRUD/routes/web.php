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

Route::get('/jogadores', 'Jogadores@index');

Route::get('/jogadores_form/{jogador?}','Jogadores@pegarForm');
Route::post('/jogadores_form/{jogador?}','Jogadores@enviarForm');

Route::get('/tipos_de_partida', 'Tipos_de_partida@index');

Route::get('/tipos_de_partida_form/{tipo_de_partida?}','Tipos_de_partida@pegarForm');
Route::post('/tipos_de_partida_form/{tipo_de_partida?}','Tipos_de_partida@enviarForm');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
