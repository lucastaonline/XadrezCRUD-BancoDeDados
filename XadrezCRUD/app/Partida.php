<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    protected $table = 'Partida';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_jogador_brancas', 'id_jogador_negras', 'data_da_partida','id_jogador_vencedor','id_controle_tempo'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data_da_partida' => 'datetime',
    ];
}
