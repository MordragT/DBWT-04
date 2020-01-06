<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class ProdukteModel extends Model
{
    public function getProdukte()
    {
        return DB::select('SELECT m.ID, m.`Name`, m.Verfügbar, Kategorien.ID as Kategorie, Bilder.`Alt-Text`, Bilder.Binärdaten, Vegan.Vegan, Vegetarisch.Vegetarisch FROM Mahlzeiten m
        INNER JOIN hatB ON m.ID = hatB.Mahlzeiten_ID
        INNER JOIN Bilder ON hatB.Bilder_ID = Bilder.ID
        INNER JOIN Kategorien ON m.Kategorie_ID = Kategorien.ID
        LEFT JOIN (SELECT Zutaten.Vegan, Mahlzeiten.ID 
            FROM Zutaten, enthältZ, Mahlzeiten 
            WHERE Zutaten.ID = enthältZ.Zutaten_ID AND Mahlzeiten.ID = enthältZ.Mahlzeiten_ID AND Zutaten.Vegan = 0
            GROUP BY Mahlzeiten.ID) Vegan ON m.ID = Vegan.ID
        LEFT JOIN (SELECT Zutaten.Vegetarisch, Mahlzeiten.ID 
            FROM Zutaten, enthältZ, Mahlzeiten 
            WHERE Zutaten.ID = enthältZ.Zutaten_ID AND Mahlzeiten.ID = enthältZ.Mahlzeiten_ID AND Zutaten.Vegetarisch = 0
            GROUP BY Mahlzeiten.ID) Vegetarisch ON m.ID = Vegetarisch.ID');
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
