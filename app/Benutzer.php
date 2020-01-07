<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Benutzer extends Authenticatable
{
    use Notifiable;

    protected $table = 'Benutzer';
    protected $primaryKey = 'Nummer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'E-mail',
        'Benutzername',
        'Vorname',
        'Nachname',
        'Hash',
        'Geburtsdatum',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'Hash', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getPasswordAttribute() {
        return $this->Hash;
    }
}

