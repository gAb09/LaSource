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

Route::get('livraison/combodate/{valeur}', 'LivraisonController@getComboDate');

Route::any('/', function () {
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


// User...
	Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@Main']);


// CLIENT...
	Route::get('client/getdeleted', ['as' => 'client.getdeleted', 'uses' => 'ClientController@getDeleted']);
	Route::get('espaceclient', ['as' => 'espaceclient', 'uses' => 'ClientController@espaceclient']);

	Route::resource('client', 'ClientController');


// MODE DE PAIEMENT...
	Route::get('modepaiement/getdeleted', ['as' => 'modepaiement.getdeleted', 'uses' => 'ModePaiementController@getDeleted']);
	Route::resource('modepaiement', 'ModePaiementController');
	Route::get('setrangs/modepaiement', ['as' => 'media.set_rang', 'uses' => 'ModePaiementController@setRangs']);



// RELAIS...
	Route::get('relais/getdeleted', ['as' => 'relais.getdeleted', 'uses' => 'RelaisController@getDeleted']);
	Route::resource('relais', 'RelaisController');
	Route::get('setrangs/relais', ['as' => 'media.set_rang', 'uses' => 'RelaisController@setRangs']);


// PRODUCTEUR...
	Route::get('producteur/getdeleted', ['as' => 'producteur.getdeleted', 'uses' => 'ProducteurController@getDeleted']);
	Route::resource('producteur', 'ProducteurController');
	Route::get('setrangs/producteur', ['as' => 'media.set_rang', 'uses' => 'ProducteurController@setRangs']);


// PANIER...
	Route::get('panier/getdeleted', ['as' => 'panier.getdeleted', 'uses' => 'PanierController@getDeleted']);
	Route::resource('panier', 'PanierController');
	Route::get('setrangs/panier', ['as' => 'media.set_rang', 'uses' => 'PanierController@setRangs']);


// LIVRAISON...

	// Pivot Panier
	Route::get('livraison/{livraison_id}/listpaniers', 
		['as' => 'livraisonListpaniers', 'uses' => 'LivraisonController@listPaniers']
		);

	Route::any('livraison/{livraison}/detachpanier/{panier}', 
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
	
// DASHBOARD
	//composerMails
	Route::get('dashboard/composerMails', 
		['as' => 'dashboardComposerMails', 'uses' => 'DashboardController@composerMails']
		);


	Route::resource('livraison', 'LivraisonController');


// Menus...
	Route::resource('menus', '\Menus\MenuController');

});


