<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Abertura extends Model
{
    protected $table = 'Abertura';

    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome'
    ];
}
