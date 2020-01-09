<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kommentar extends Model
{
    protected $table = 'Kommentare';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $fillable = ['Bewertung', 'Bemerkung'];

    public function student() {
        return $this->belongsTo('App\Student', 'Studenten_Nummer');
    }

    public function mahlzeit() {
        return $this->belongsTo('App\Mahlzeit', 'Mahlzeiten_ID');
    }
}

