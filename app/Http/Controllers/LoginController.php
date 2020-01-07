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

    /**
     * Get the password for the user.
     *
     * @return string
     */

    public function login(Request $request)
    {

        //Validate Form
        $this->validate($request, [
            'Benutzername' => 'required',
            'password' => 'required',
        ]);

        //Attempt to Login
        if (Auth::attempt(['Benutzername' => $request->Benutzername, 'password' => $request->password], $request->remember)) {
            //Succesfull: redirect to intended location
            return redirect()->intended(route('home'));
        }

        //Unsuccesfull: redirect to form
        return redirect()->back()->withInput($request->only('Benutzername', 'password'));
    }

    public function showLoginForm()
    {
        return view('Login.Login', []);
    }
}
