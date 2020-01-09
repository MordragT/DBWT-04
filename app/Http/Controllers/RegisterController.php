<?php

namespace App\Http\Controllers;

use App\Benutzer;
use App\Fachbereich;
use App\GehörtZu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function validateFirstForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Benutzername' => 'required|unique:Benutzer|max:255',
            'password' => 'required|confirmed|min:6',
            'Mitarbeiter' => 'alpha',
            'Student' => 'alpha',
        ], [
            'Benutzername.unique' => 'Dieser Benutzername wird bereits benutzt.',
            'password.confirmed' => 'Die eingegebenen Passwörter sind ungleich.',
        ]);

        if ($validator->fails()) {
            return redirect(route('register'))
                ->withErrors($validator)
                ->withInput();
        } else {
            $temp = $validator->validated();
            $temp['password'] = Hash::make($temp['password']);
            $request->session()->flush();
            $request->session()->put('firstForm', $temp);
            return redirect(route('register.last'));
        }
    }

    public function register(Request $request)
    {
        $mitarbeiter = isset($request->session()->get('firstForm')['Mitarbeiter']);
        $student = isset($request->session()->get('firstForm')['Student']);

        $validator = Validator::make($request->all(), [
            'Vorname' => 'required|max:255',
            'Nachname' => 'required|max:255',
            'Email' => 'required|unique:Benutzer',
            'Geburtsdatum' => 'date',
            'Grund' => Rule::requiredIf(!$mitarbeiter and !$student),
            'Fachbereich' => Rule::requiredIf($mitarbeiter or $student),
            'Matrikelnummer' => Rule::requiredIf($student),
            'Studiengang' => Rule::requiredIf($student),
            'Telefon' => 'max:15',
            'Büro' => 'max:4',
        ], [
            'Email.unique' => 'Diese Email wird bereits benutzt.'
        ]);

        if ($validator->fails()) {
            return redirect(route('register.last'))
                ->withErrors($validator)
                ->withInput();
        } else {
            $user = Benutzer::create([
                'Benutzername' => $request->session()->get('firstForm')['Benutzername'],
                'Hash' => $request->session()->get('firstForm')['password'],
                'Vorname' => $validator->validated()['Vorname'],
                'Nachname' => $validator->validated()['Nachname'],
                'Email' => $validator->validated()['Email'],
            ]);

            if ($mitarbeiter || $student) {
                $angehöriger = $user->angehöriger()->create();
                $fachbereich = Fachbereich::where('Name', $validator->validated()['Fachbereich'])->first();
                GehörtZu::create([
                    'Nummer_FH_Angehörige' => $angehöriger->Benutzer_Nummer,
                    'Fachbereiche_ID' => $fachbereich->ID,
                ]);
                if ($mitarbeiter) {
                    $mitarbeiter = $angehöriger->mitarbeiter()->create();
                    $mitarbeiter->Telefon = isset($validator->validated()['Telefon']) ?: $validator->validated()['Telefon'];
                    $mitarbeiter->Telefon = isset($validator->validated()['Büro']) ?: $validator->validated()['Büro'];
                }
                if ($student) {
                    $angehöriger->student()->create([
                        'Matrikelnummer' => $validator->validated()['Matrikelnummer'],
                        'Studiengang' => $validator->validated()['Studiengang'],
                    ]);
                }
            } else {
                $user->gast()->create(['Grund' => $validator->validated()['Grund']]);
            }

            $request->session()->put('id', $user->Nummer);
            return redirect(route('register.success'));
        }
    }

    public function showFirstRegistrationForm()
    {
        return view('Registrieren.RegistrierenFormFirst');
    }

    public function showRegistrationForm(Request $request)
    {
        if ($request->session()->has('firstForm')) {
            $mitarbeiter = isset($request->session()->get('firstForm')['Mitarbeiter']);
            $student = isset($request->session()->get('firstForm')['Student']);

            return view('Registrieren.RegistrierenForm', [
                'mitarbeiter' => $mitarbeiter,
                'student' => $student,
                'studiengaenge' => ['ET', 'INF', 'ISE', 'MCD', 'WI'],
                'test' => $request->session()->get('firstForm'),
                'fachbereiche' => Fachbereich::all(),
            ]);
        } else return view('404');
    }
}
