<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Zutat extends Model
{
    protected $table = 'Zutaten';
    protected $primaryKey = 'ID';
    public $timestamps = false;
}
