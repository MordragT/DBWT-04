<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class RegistrierenModel extends Model
{
    public $studiengaenge = array('ET', 'INF', 'ISE', 'MCD', 'WI');

    public function getFachbereiche()
    {
        return DB::select('select * from Fachbereiche');
    }

    public function checkBenutzername($name)
    {
        $result = DB::select('select * from Benutzer where Benutzername = ?', [$name]);
        return sizeof($result) == 0;
    }

    public function checkMatrikelnummer($nummer)
    {
        $result = DB::select('select * from Studenten where Matrikelnummer = ?', [$nummer]);
        return sizeof($result) == 0;
    }

    public function checkEmail($email)
    {
        $result = DB::select('select * from Benutzer where `E-Mail` = ?', [$email]);
        return sizeof($result) == 0;
    }

    public function eintragen(Benutzer $benutzer)
    {

        mysqli_autocommit($this->remoteConnection, false);

        $query = 'INSERT INTO Benutzer(Benutzername,`Hash`,`E-Mail`,`Vorname`,`Nachname`,`Aktiv`) VALUES
                      ("' . $benutzer->benutzername . '","' . $benutzer->getHash() . '","' . $benutzer->email . '","' . $benutzer->vorname . '","' . $benutzer->nachname . '",' . TRUE . ');';
        mysqli_query($this->remoteConnection, $query);

        $id = mysqli_insert_id($this->remoteConnection);
        $_SESSION['new_id'] = $id;

        if ($benutzer->student != null or $benutzer->mitarbeiter != null) {
            $query = 'INSERT INTO `FH Angehörige`(Benutzer_Nummer) VALUES
                ("' . $id . '");';
            mysqli_query($this->remoteConnection, $query);
            if ($benutzer->student == 'student') {
                $query = 'INSERT INTO `Studenten`(Matrikelnummer,Studiengang,`FH Angehörige_Nummer`) VALUES
                    ("' . $benutzer->matrikelnummer . '","' . $benutzer->studiengang . '","' . $id . '");';
                mysqli_query($this->remoteConnection, $query);
            } else if ($benutzer->mitarbeiter == 'mitarbeiter') {
                $query = 'INSERT INTO Mitarbeiter (`FH Angehörige_Nummer`,`Büro`,Telefon) VALUES
                    ("' . $id . '","' . $benutzer->büro . '",' . $benutzer->telefon . ');';
                mysqli_query($this->remoteConnection, $query);
            }
        }
        if (!mysqli_commit($this->remoteConnection)) {
            mysqli_rollback($this->remoteConnection);
            exit();
        }
        mysqli_commit($this->remoteConnection);
    }
}
