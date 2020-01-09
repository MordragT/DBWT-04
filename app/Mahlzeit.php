<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Mahlzeit extends Model
{
    protected $table = 'Mahlzeiten';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    public function getBilderAttribute()
    {
        return DB::select('select b.`Binärdaten`,b.`Alt-Text` 
        from Bilder b,Mahlzeiten m, hatB mb
        where m.ID = ?
        and m.ID = mb.Mahlzeiten_ID
        and b.ID = mb.Bilder_ID', [$this->ID])[0];
    }

    public function getZutatenAttribute()
    {
        return DB::select('select z.*
        from Zutaten z,Mahlzeiten m,enthältZ mz 
        where z.ID = mz.Zutaten_ID and m.ID = mz.Mahlzeiten_ID and m.ID = ?
        order by Bio desc,Name', [$this->ID]);
    }

    public function getBewertungAttribute()
    {
        return Kommentar::where('Mahlzeiten_ID', $this->ID)->avg('Bewertung');
        //return $this->kommentar->avg('Bewertung');
    }
    public function enthältz()
    {
        return $this->belongsTo('App\EnthältZ', 'ID');
    }
    public function hatb()
    {
        return $this->belongsTo('App\HatB', 'ID');
    }
    public function kommentare()
    {
        return $this->hasMany('App\Kommentar', 'Mahlzeiten_ID');
    }
    public function preis()
    {
        return $this->hasOne('App\Preis', 'Mahlzeiten_ID');
    }
}

class HatB extends Model
{
    protected $table = 'hatB';
    public $incrementing = false;
    protected $primaryKey = ['Bilder_ID','Mahlzeiten_ID'];
    public $timestamps = false;
    protected $fillable = ['Bilder_ID','Mahlzeiten_ID'];
    public function bilder() 
    {
        return $this->hasMany('App\Bilder', 'ID');
    }
    public function mahlzeiten() 
    {
        return $this->hasMany('App\Mahlzeit', 'ID');
    }
}

class EnthältZ extends Model
{
    protected $table = 'enthältZ';
    public $incrementing = false;
    protected $primaryKey = ['Zutaten_ID','Mahlzeiten_ID'];
    public $timestamps = false;
    protected $fillable = ['Zutaten_ID','Mahlzeiten_ID'];
    public function zutaten() 
    {
        return $this->hasMany('App\Zutat', 'ID');
    }
    public function mahlzeiten()
    {
        return $this->hasMany('App\Mahlzeit', 'ID');
    }
}