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
}

