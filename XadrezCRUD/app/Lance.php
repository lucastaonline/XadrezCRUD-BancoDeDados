<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lance extends Model
{
    protected $table = 'Lance';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_partida','id_jogador','nome','numero_lance','id_avaliacao_lance','mudanca_avaliacao','id_abertura','id_momento_partida'
    ];
}
