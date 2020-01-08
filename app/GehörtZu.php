<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

