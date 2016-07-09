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

// User...
	Route::resource('user', 'UserController');


// Client...
	Route::get('espaceclient', ['as' => 'espaceclient', 'uses' => 'ClientController@espaceclient']);

	Route::resource('client', 'ClientController');


// Relais...
	Route::resource('relais', 'RelaisController');


// Producteur...
	Route::resource('producteur', 'ProducteurController');


// Panier...
	Route::resource('panier', 'PanierController');


// Livraison...
	Route::resource('livraison', 'LivraisonController');

	// Pivot Panier
	Route::get('livraison/{livraison_id}/listpaniers', 
		['as' => 'livraisonListpaniers', 'uses' => 'LivraisonController@listPaniers']
		);

	Route::post('livraison/{livraison}/detachpanier/{panier}', 
		['as' => 'livraisonDetachPanier', 'uses' => 'LivraisonController@detachPanier']
		);

	Route::post('livraison/{livraison}/syncPaniers', 
		['as' => 'livraisonSyncPaniers', 'uses' => 'LivraisonController@syncPaniers']
		);


// Pivot Panier / Producteur...
	Route::get('livraison/panier/{panier_id}/listProducteurs', 
		['as' => 'listProducteursForPanier', 'uses' => 'LivraisonController@listProducteursForPanier']
		);

	Route::post('panier/{panier_id}/syncProducteurs', 
		['as' => 'PanierSyncProducteurs', 'uses' => 'PanierController@syncProducteurs']
		);
	


// ModePaiement...
	Route::resource('modepaiement', 'ModePaiementController');

// Menus...
	Route::resource('menus', '\Menus\MenuController');

});


