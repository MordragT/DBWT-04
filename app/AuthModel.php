<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AuthModel extends Model
{
    public function getBenutzerByName($name)
    {
        return DB::select('select * from Benutzer where Benutzername = ?', [$name]);
    }

    public function setLetzterLogin($name)
    {
        DB::update('update Benutzer set LetzterLogin = ? where Benutzername = ?', [date('Y-m-d'),$name]);
    }

    public function getTyp($name)
    {
        return DB::select('select Typ from Benutzertyp where Benutzername = ?',[$name])[0]->Typ;
    }
}
