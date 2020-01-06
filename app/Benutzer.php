<?php

namespace App;

class Benutzer
{

    public $benutzername;
    public $vorname;
    public $nachname;
    public $email;
    public $geburtsdatum;
    public $fachbereich;
    public $matrikelnummer;
    public $studiengang;
    public $student;
    public $mitarbeiter;
    public $büro;
    public $telefon;
    private $hash;

    public function setPasswort($passwort)
    {
        $this->hash = password_hash($passwort, PASSWORD_BCRYPT);
    }

    public function getHash()
    {
        return $this->hash;
    }
}
