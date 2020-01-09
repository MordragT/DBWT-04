<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Angehöriger extends Model
{
    protected $table = 'FH_Angehörige';
    protected $primaryKey = 'Benutzer_Nummer';
    public $timestamps = false;
    public $incrementing = false;


    public function student() {
        return $this->hasOne('App\Student', 'FH_Angehörige_Nummer');
    }
    public function mitarbeiter() {
        return $this->hasOne('App\Mitarbeiter', 'FH_Angehörige_Nummer');
    }
    public function benutzer() {
        return $this->belongsTo('App\Benutzer', 'Benutzer_Nummer');
    }
}

class GehörtZu extends Model
{
    protected $table = 'gehörtZu';
    public $incrementing = false;
    protected $primaryKey = ['Nummer_FH_Angehörige','Fachbereiche_ID'];
    public $timestamps = false;
    protected $fillable = ['Nummer_FH_Angehörige','Fachbereiche_ID'];
    public function angehöriger() {
        return $this->hasOne('App\Angehöriger', 'Benutzer_Nummer');
    }
    public function fachbereich() {
        return $this->hasOne('App\Fachbereich', 'ID');
    }
}
