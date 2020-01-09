<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preis extends Model
{
    protected $table = 'Preise';
    public $incrementing = false;
    protected $primaryKey = 'Mahlzeiten_ID';
    public $timestamps = false;
    protected $fillable = ['Jahr', 'Gastpreis', 'MA-Preis', 'Studentpreis'];

    public function mahlzeit() {
        return $this->belongsTo('App\Mahlzeit', 'Mahlzeiten_ID');
    }
}

