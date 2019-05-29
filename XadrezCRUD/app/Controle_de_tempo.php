<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Controle_de_tempo extends Model
{
    protected $table = 'Controle_de_tempo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tempo_partida','tem_incremento','incremento','id_tipo_de_partida'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'tem_incremento' => 'boolean',
    ];
}
