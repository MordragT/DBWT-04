<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Gast extends Authenticatable {

    use Notifiable;

    protected $table = 'Gäste';
    protected $primaryKey = 'Benutzer_Nummer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['Grund'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];
}