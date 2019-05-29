<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jogador extends Model
{
    protected $table = 'Jogador';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rating'
    ];

}
