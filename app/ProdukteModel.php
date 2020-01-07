<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class ProdukteModel extends Model
{
    public function getProdukte($vegan, $vegetarisch)
    {
        if($vegetarisch and !$vegan) return DB::select('select * from Mahlzeitentypen where Mahlzeitentypen.Vegetarisch IS NULL');
        else if($vegan) return DB::select('select * from Mahlzeitentypen where Mahlzeitentypen.Vegan IS NULL');
        else return DB::select('select * from Mahlzeitentypen');
    }

    public function getOptGroups()
    {
        return DB::select('select * from Kategorien where Kategorien_ID is null');
    }

    public function getOptions()
    {
        return DB::select('select * from Kategorien where Kategorien_ID is not null');
    }

}
