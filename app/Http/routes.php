<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
	return view('accueil');
});



// Authentication Routes...
$this->get('connexion', 'Auth\AuthController@showLoginForm');
$this->post('connexion', 'Auth\AuthController@connexion');
$this->get('deconnexion', 'Auth\AuthController@deconnexion');

// Registration Routes...
$this->get('inscription', 'Auth\AuthController@showRegistrationForm');
$this->post('inscription', 'Auth\AuthController@register');

// Password Reset Routes...
$this->get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
$this->post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
$this->post('password/reset', 'Auth\PasswordController@reset');

// Transfert Routes...
$this->post('transfert/resetoldlogin', 'Auth\AuthController@ResetOldloginViaMail');


Route::group(['middleware' => 'auth'], function () {

	Route::get('/espaceclient', 'EspaceClientController@index');

	Route::resource('menus', '\Menus\MenuController');

});


