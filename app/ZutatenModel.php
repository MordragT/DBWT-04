<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class ZutatenModel extends Model
{
    public function getZutaten()
    {
        return DB::select('select * from Zutaten order by Bio desc, Name');
    }
}
