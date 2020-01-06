<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DetailModel extends Model
{
    public function getById($id)
    {
        return DB::select('select m.Beschreibung,m.`Name`, b.`Binärdaten`,p.`Gastpreis`,p.`MA-Preis` as Mitarbeiterpreis,p.StudentPreis as Studierendenpreis, b.`Alt-Text` 
        from Bilder b,Mahlzeiten m, Preise p, hatB mb
        where m.ID = ?
        and m.ID = mb.Mahlzeiten_ID
        and b.ID = mb.Bilder_ID
        and p.Mahlzeiten_ID = m.ID', [$id])[0];
    }

    public function getZutatenById($id)
    {
        return DB::select('select z.*, m.ID, mz.* 
        from Zutaten z,Mahlzeiten m,enthältZ mz 
        where z.ID = mz.Zutaten_ID and m.ID = mz.Mahlzeiten_ID and m.ID = ?
        order by Bio desc,Name', [$id]);
    }
}
