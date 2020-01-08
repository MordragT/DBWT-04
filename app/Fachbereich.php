<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fachbereich extends Model
{
    protected $table = 'Fachbereiche';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $fillable = ['Website', 'Name', 'Adresse'];
}
