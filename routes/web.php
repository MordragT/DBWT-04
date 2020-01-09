<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Zutat;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view("Start.Start");
})->name('home');

Route::get('/detail', 'DetailController@createView')->name('details');

Route::get('/produkte', 'ProdukteController@createView')->name('products');

Route::get('/zutatenliste', function() {
    return view('Zutaten.Zutaten', ['zutaten' => Zutat::orderBy('Bio', 'desc')->get()]);
})->name('ingredients');

Route::get('/impressum', function() {
    return view("Impressum.Impressum");
})->name('imprint');

Auth::routes();

Route::get('/register', 'RegisterController@showFirstRegistrationForm')->name('register');
Route::post('/register', 'RegisterController@validateFirstForm')->name('register.first.submit');

Route::get('/register/last', 'RegisterController@showRegistrationForm')->name('register.last');
Route::post('/register/last', 'RegisterController@register')->name('register.last.submit');

Route::get('/register/success', function(Request $request) {
    return $request->session()->has('id') ? view('Registrieren.RegistrierenErfolgreich', ['id' => $request->session()->get('id')]) : view('404');
})->name('register.success');

Route::get('/login/successful', function() {
    return view('Login.LoginSuccessful');
})->middleware('auth')->name('login.successful');

Route::get('/login', 'LoginController@showLoginForm')->name('login');
Route::post('/login', 'LoginController@login')->name('login.submit');

