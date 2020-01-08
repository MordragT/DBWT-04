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
}

