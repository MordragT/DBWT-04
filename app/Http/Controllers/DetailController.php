<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Mahlzeit;
use Illuminate\Http\Request;
use App\Student;
use Illuminate\Support\Facades\Auth;
use App\Kommentar;

class DetailController extends Controller
{
    public function comment(Request $request, $id)
    {
        $this->validate($request, [
            'bewertung' => 'required|numeric|min:1|max:5',
        ]);

        $student = Student::find(Auth::user()->Nummer);
        $kommentar = new Kommentar([
            'Bewertung' => $request->bewertung,
        ]);
        if(isset($request->bemerkung)) $kommentar->Bemerkung = $request->bemerkung;
        $kommentar->student()->associate($student);
        $kommentar->mahlzeit()->associate(Mahlzeit::find($id));
        $kommentar->save();

        return redirect(route('details', $id));
    }

    public function createView($id)
    {
        $mahlzeit = Mahlzeit::find($id);

        if (!empty($mahlzeit)) {
            return view("Detail.Mahlzeit", [
                'zutaten' => $mahlzeit->zutaten,
                'mahlzeit' => $mahlzeit,
                'kommentare' => Kommentar::where('Mahlzeiten_ID', $mahlzeit->ID)->orderBy('Zeitpunkt', 'desc')->take(5)->get(),
                'id' => $id,
            ]);
        } else return view('Detail.NotFound');
        
    }
}
