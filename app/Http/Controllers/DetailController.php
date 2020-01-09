<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Mahlzeit;

class DetailController extends Controller
{
    public function createView()
    {
        if (isset($_POST['comment'])) {
            $date = date("Y-m-d H:i:s");
            $comment_user = DB::select('SELECT Nummer FROM Benutzer WHERE Benutzername = "' . $_POST['benutzer'] . '";');
            $comment_mahlzeit = DB::select('SELECT ID FROM Mahlzeiten WHERE Name = "' . $_POST['mahlzeit'] . '";');
            $test = DB::select('SELECT Bewertung FROM Kommentare WHERE student_id = ' . $comment_user[0]->Nummer . 'AND mahlzeit_id = ' . $comment_mahlzeit[0]->ID . ';');
            if (empty($test)) {
                if (isset($_POST['bemerkung'])) {
                    DB::insert('INSERT INTO Kommentare(Bewertung,Bemerkung,mahlzeit_id,student_id,Zeitpunkt) VALUES
                    (' . $_POST['bewertung'] . ',"' . $_POST['bemerkung'] . '",' . $comment_mahlzeit[0]->ID . ',' . $comment_user[0]->Nummer . ',"' . $date . '")');
                } else {
                    DB::insert('INSERT INTO Kommentare(Bewertung,mahlzeit_id,student_id,Zeitpunkt) VALUES
                    (' . $_POST['bewertung'] . ',' . $comment_mahlzeit[0]->ID . ',' . $comment_user[0]->Nummer . ',"' . $date . '");');
                }
            } else {
                if (isset($_POST['bemerkung'])) {
                    DB::update('UPDATE Kommentare
                        SET Bewertung = ' . $_POST['bewertung'] . ', Bemerkung = "' . $_POST['bemerkung'] . '", Zeitpunkt = "' . $date . '"
                        WHERE student_id = ' . $comment_user[0]->Nummer . '
                        AND mahlzeit_id = ' . $comment_mahlzeit[0]->ID . ';');
                } else {
                    DB::update('UPDATE Kommentare
                        SET Bewertung = ' . $_POST['bewertung'] . ', Zeitpunkt = "' . $date . '"
                        WHERE student_id = ' . $comment_user[0]->Nummer . '
                        AND mahlzeit_id = ' . $comment_mahlzeit[0]->ID . ';');
                }
            }
        }

        $id = isset($_GET['id']) ? $_GET['id'] : 404;
        $mahlzeit = Mahlzeit::find($id);

        if (empty($mahlzeit)) {
            $id = 404;
            return view('Detail.Detail', ['id' => $id]);
        } 
        return view("Detail.Detail", ['produkt' => $mahlzeit->getBilderPreise(), 'id' => $id, 'zutaten' => $mahlzeit->getZutaten()]);
    }
}
