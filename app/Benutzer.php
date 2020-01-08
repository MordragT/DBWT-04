<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class Benutzer extends Authenticatable
{
    use Notifiable;

    protected $table = 'Benutzer';
    protected $primaryKey = 'Nummer';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Email',
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
    protected $hidden = ['Hash'];

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

    public function getTypAttribute() {
        return DB::select('select Typ from Benutzertyp where Benutzername = ?',[$this->Benutzername])[0]->Typ;
    }

    public function gast() {
        return $this->hasOne('App\Gast','Benutzer_Nummer');
    }

    public function angehöriger() {
        return $this->hasOne('App\Angehöriger','Benutzer_Nummer');
    }
}

