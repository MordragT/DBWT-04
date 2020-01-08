<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mitarbeiter extends Model
{
    protected $table = 'Mitarbeiter';
    protected $primaryKey = 'FH_Angehörige_Nummer';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['Büro', 'Telefon'];
}

