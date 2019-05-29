<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Momento_partida extends Model
{
    protected $table = 'Momento_partida';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome'
    ];
}
