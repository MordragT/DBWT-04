<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\AuthModel;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
        $this->model = new AuthModel();
    }

    public function login(Request $request)
    {
        //Validate Form
        $this->validate($request, [
            'Benutzername' => 'required|exists:Benutzer',
            'password' => 'required|password',
        ], [
            'Benutzername.exists' => 'Der eingegebene Benutzername existiert nicht.',
            'password' => 'Das eingebene Passwort ist falsch.'
        ]);

        //Attempt to Login
        if (Auth::attempt(['Benutzername' => $request->Benutzername, 'password' => $request->password], $request->remember)) {
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
