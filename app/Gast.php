<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gast extends Model
{
    protected $table = 'Gäste';
    protected $primaryKey = 'Benutzer_Nummer';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['Grund'];
}

