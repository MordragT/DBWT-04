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

Route::get('/', function () {
    return view("Start.Start");
})->name('home');

Route::get('/home', function () {
    return view("Start.Start");
})->name('home');

Route::match(['get', 'post'],'/detail', 'DetailController@createView');

Route::get('/produkte', 'ProdukteController@createView');

Route::get('/zutatenliste', 'ZutatenController@createView');

Route::get('/impressum', function() {
    return view("Impressum.Impressum");
});

Route::get('/registrieren', 'RegistrierenController@createView');

Route::get('/login', 'LoginController@showLoginForm')->name('login');
Route::post('/login', 'LoginController@login')->name('login.submit');
