<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variacao_rating extends Model
{
    protected $table = 'Variacao_rating';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_partida','id_jogador','variacao'
    ];
}
