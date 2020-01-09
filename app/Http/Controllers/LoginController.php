<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function login(Request $request)
    {
        //Validate Form
        $this->validate($request, [
            'Benutzername' => 'required|exists:Benutzer',
            'password' => 'required',
        ], [
            'Benutzername.exists' => 'Der eingegebene Benutzername existiert nicht.',
            'password' => 'Das eingebene Passwort ist falsch.'
        ]);

        //Attempt to Login
        if (Auth::attempt(['Benutzername' => $request->Benutzername, 'password' => $request->password], $request->remember)) {

            $user = Auth::user();
            $user->LetzterLogin = date('Y-m-d');
            $user->save();

            //Succesfull: redirect to intended location
            return redirect()->intended(route('login.successful'));
        }

        //Unsuccesfull: redirect to form
        return redirect()->back()->withInput($request->only('Benutzername', 'password'));
    }
    
    public function showLoginForm()
    {
        return view('Login.Login', []);
    }
}
