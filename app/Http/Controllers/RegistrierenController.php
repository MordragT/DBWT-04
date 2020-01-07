<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\RegistrierenModel;
use App\Benutzer;
use Illuminate\Contracts\View\View;

class RegistrierenController extends Controller
{
    protected $model;
    protected $benutzer;
    private $tmpPasswort;

    function __construct()
    {
        $this->model = new RegistrierenModel();
        $this->benutzer = new Benutzer();
    }

    protected function firstPage()
    {
        return View('Registrieren.RegistrierenFormBase', [
            'benutzer' => $this->benutzer,
            'benutzername' => $this->benutzer->benutzername,
            'error' => $_SESSION['error'],
        ]);
    }

    protected function secondPage()
    {
        return view('Registrieren.RegistrierenFormNext', [
            'benutzer' => $this->benutzer,
            'benutzername' => $this->benutzer->benutzername,
            'passwort' => $this->tmpPasswort,
            'vorname' => $this->benutzer->vorname,
            'nachname' => $this->benutzer->nachname,
            'email' => $this->benutzer->email,
            'geburtsdatum' => $this->benutzer->geburtsdatum,
            'fachbereich' => $this->benutzer->fachbereich,
            'fachbereiche' => $this->model->getFachbereiche(),
            'matrikelnummer' => $this->benutzer->matrikelnummer,
            'studiengang' => $this->benutzer->studiengang,
            'studiengaenge' => $this->model->studiengaenge,
            'student' => $this->benutzer->student,
            'mitarbeiter' => $this->benutzer->mitarbeiter,
            'büro' => $this->benutzer->büro,
            'telefon' => $this->benutzer->telefon,
            'error' => $_SESSION['error'],
        ]);
    }

    protected function thirdPage()
    {
        return view('Registrieren.RegistrierenErfolgreich', ['benutzer' => $this->benutzer]);
    }

    public function createView()
    {
        session_start();
        $_SESSION['error']['initial'] = "asdasda";
        $this->benutzer->benutzername = isset($_POST['reg-benutzername']) ? $_POST['reg-benutzername'] : null;
        $this->benutzer->student = isset($_POST['student']) ? $_POST['reg-benutzername'] : null;
        $this->benutzer->mitarbeiter = isset($_POST['mitarbeiter']) ? $_POST['mitarbeiter'] : null;
        $this->benutzer->vorname = isset($_POST['reg-vorname']) ? $_POST['reg-vorname'] : null;
        $this->benutzer->nachname = isset($_POST['reg-nachname']) ? $_POST['reg-nachname'] : null;
        $this->benutzer->email = isset($_POST['reg-email']) ? $_POST['reg-email'] : null;
        $this->benutzer->geburtsdatum = isset($_POST['reg-geburtsdatum']) ? $_POST['reg-geburtsdatum'] : null;
        $this->benutzer->fachbereich = isset($_POST['reg-fachbereich']) ? $_POST['reg-fachbereich'] : null;
        $this->benutzer->matrikelnummer = isset($_POST['reg-matrikelnummer']) ? $_POST['reg-matrikelnummer'] : null;
        $this->benutzer->studiengang = isset($_POST['reg-studiengang']) ? $_POST['reg-studiengang'] : null;
        $this->benutzer->büro = isset($_POST['reg-büro']) ? $_POST['reg-büro'] : null;
        $this->benutzer->telefon = isset($_POST['reg-telefon']) ? $_POST['reg-telefon'] : null;

        if (isset($_POST['reg-passwort']) and isset($_POST['reg-passwort-w']) and $_POST['reg-passwort'] != $_POST['reg-passwort-w'] and $_POST['final-passwort'] == null) {
            $_SESSION['error']['passwort'] = "Sie haben zwei verschiedene Passwörter eingegeben!";
        } else {
            unset($_SESSION['error']['passwort']);
        }
        if (isset($_POST['final-passwort'])) {
            $this->tmpPasswort = $_POST['final-passwort'];
            $this->benutzer->setPasswort($_POST['final-passwort']);
        } else if (isset($_POST['reg-passwort']) && $_POST['reg-passwort'] == $_POST['reg-passwort-w']) {
            $this->tmpPasswort = $_POST['reg-passwort'];
        }
        /*
            if ($this->benutzer->gast != null and ($this->benutzer->student != null or $this->benutzer->student != null)) {
                $_SESSION['error']['typ'] = "Sie können nicht gleichzeitig Gast und Student/Mitarbeiter sein!";
            } else {
                unset($_SESSION['error']['typ']);
            }
            if ($this->benutzer->benutzername != null and $this->benutzer->gast == null and $this->benutzer->student == null and $this->benutzer->student == null) {
                $_SESSION['error']['typ'] = "Sie haben keinen Typ angegeben!";
            } else {
                unset($_SESSION['error']['typ']);
            }
            */
        if (isset($_POST['reg-benutzername']) and !$this->model->checkBenutzername($_POST['reg-benutzername'])) {
            $_SESSION['error']['benutzername'] = "Dieser Benutzername wird leider schon verwendet!";
        } else {
            unset($_SESSION['error']['benutzername']);
        }
        if (isset($_POST['reg-matrikelnummer']) and !$this->model->checkMatrikelnummer($_POST['reg-matrikelnummer'])) {
            $_SESSION['error']['matrikelnummer'] = "Ein Benutzer mit dieser Matrikelnummer ist bereits eingetragen";
        } else {
            unset($_SESSION['error']['matrikelnummer']);
        }
        if (isset($_POST['reg-email']) and !$this->model->checkEmail($_POST['reg-email'])) {
            $_SESSION['error']['email'] = "Diese Email wird leider schon verwendet!";
        } else {
            unset($_SESSION['error']['email']);
        }

        if (!isset($_POST['page'])) {
            $this->firstPage();
        } else if ($_POST['page'] == "next") {
            if (!empty($_SESSION['error'])) {
                $_POST['page'] = null;
                $this->firstPage();
            } else {
                $this->secondPage();
            }
        } else if ($_POST['page'] == "success") {
            if (!empty($_SESSION['error'])) {
                $_POST['page'] = 'next';
                $this->secondPage();
            } else {
                $this->model->eintragen($this->benutzer);
                $this->thirdPage();
            }
        }
    }
}
