<?php
use Illuminate\Http\Request;

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

Route::get('accueil', function () {
	return view('accueil');
});

Route::get('lasource', function () {
	return view('lasource');
});

Route::get('lesproducteurs', function () {
	return view('lesproducteurs');
});

Route::get('lesrelais', function () {
	return view('lesrelais');
});

Route::get('lespaniers', function () {
	return view('lespaniers');
});

Route::get('leslivraisons', function () {
	return view('leslivraisons');
});



// Authentication Routes...
$this->get('connexion', 'Auth\AuthController@showLoginForm');
$this->post('connexion', 'Auth\AuthController@connexion');
$this->get('logout', 'Auth\AuthController@logout');

// Registration Routes...
$this->get('register', 'Auth\AuthController@showRegistrationForm');
$this->post('register', 'Auth\AuthController@register');

// Password Reset Routes...
$this->get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
$this->post('password/email', 'Auth\PasswordController@HandleSendingResetMail');
$this->post('password/reset', 'Auth\PasswordController@handleResetCredentials');

// Transfert Routes...
$this->get('transfert/OldLoginFailed/{pseudo?}', 'Auth\AuthController@askMailOldLoginFailed');
$this->post('transfert/OldLoginFailed', 'Auth\AuthController@HandleOldLoginFailed');


// Contact Routes...
Route::get('contactLS', 'ContactController@ContactLS');
Route::get('contactOM', 'ContactController@ContactOM');

// OuaibMaistre Routes...
$this->get('om', 'OMController@index');
$this->get('om/transfertrelais', 'OMController@transfertRelais');
$this->get('om/transfertproducteur', 'OMController@transfertProducteur');
$this->get('om/transfertpanier', 'OMController@transfertPanier');
$this->get('om/transfertlivraison', 'OMController@transfertLivraison');


Route::group(['middleware' => 'auth'], function () {

	Route::resource('user', 'UserController');

	Route::get('espaceclient', ['as' => 'espaceclient', 'uses' => 'ClientController@espaceclient']);
	Route::resource('client', 'ClientController');

	Route::resource('relais', 'RelaisController');

	Route::resource('producteur', 'ProducteurController');

// Paniers...
	Route::resource('panier', 'PanierController');
	Route::post('detach/panier/{panier}/fromlivraison/{livraison}', 
		['as' => 'panierDetachLivraison', 'uses' => 'PanierController@detachFromLivraison']
		);
	Route::post('attach/panier/{panier}/tolivraison/{livraison}', 
		['as' => 'panierAttacToLivraison', 'uses' => 'PanierController@attachToLivraison']
		);

	Route::resource('livraison', 'LivraisonController');
	Route::get('livraison/choixProducteurs/{id}', 'LivraisonController@choixProducteurs');
	

	Route::resource('modepaiement', 'ModePaiementController');

	Route::resource('menus', '\Menus\MenuController');

});


