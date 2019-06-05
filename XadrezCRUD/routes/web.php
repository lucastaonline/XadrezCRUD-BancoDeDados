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

Route::get('/controles_de_tempo', 'Controles_de_tempo@index');

Route::get('/controles_de_tempo_form/{controle_de_tempo?}','Controles_de_tempo@pegarForm');
Route::post('/controles_de_tempo_form/{controle_de_tempo?}','Controles_de_tempo@enviarForm');

Route::get('/partidas', 'Partidas@index');

Route::get('/partidas_form/{partida?}','Partidas@pegarForm');
Route::post('/partidas_form/{partida?}','Partidas@enviarForm');

Route::get('/aberturas', 'Aberturas@index');

Route::get('/aberturas_form/{abertura?}','Aberturas@pegarForm');
Route::post('/aberturas_form/{abertura?}','Aberturas@enviarForm');

Route::get('/momentos_partida', 'Momentos_partida@index');

Route::get('/momentos_partida_form/{momento_partida?}','Momentos_partida@pegarForm');
Route::post('/momentos_partida_form/{momento_partida?}','Momentos_partida@enviarForm');

Route::get('/avaliacoes_lance', 'Avaliacoes_lance@index');

Route::get('/avaliacoes_lance_form/{avaliacao_lance?}','Avaliacoes_lance@pegarForm');
Route::post('/avaliacoes_lance_form/{avaliacao_lance?}','Avaliacoes_lance@enviarForm');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
