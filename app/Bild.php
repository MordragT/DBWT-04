<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bild extends Model
{
    protected $table = 'Bilder';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $fillable = ['Alt-Text', 'Titel'];
}

