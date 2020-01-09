<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'Studenten';
    protected $primaryKey = 'FH_Angehörige_Nummer';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['Matrikelnummer', 'Studiengang'];

    public function kommentar() {
        return $this->hasMany('App\Kommentar', 'Studenten_Nummer');
    }

    public function angehöriger() {
        return $this->belongsTo('App\Angehöriger', 'FH_Angehörige_Nummer');
    }
}

