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

// Old login failed...
$this->get('transfert/OldLoginFailed/{pseudo?}', 'Auth\AuthController@askMailOldLoginFailed');
$this->post('transfert/OldLoginFailed', 'Auth\AuthController@HandleOldLoginFailed');


// Contact Routes...
Route::get('contactLS', 'ContactController@ContactLS');
Route::get('contactOM', 'ContactController@ContactOM');

// Transfert Routes...
$this->get('transfert', 'TransfertController@index');
$this->get('transfert/clients', 'TransfertController@client');
$this->get('transfert/relais', 'TransfertController@relais');
$this->get('transfert/producteurs', 'TransfertController@producteurs');
$this->get('transfert/paniers', 'TransfertController@paniers');
$this->get('transfert/livraisons', 'TransfertController@livraisons');
$this->get('transfert/commandes', 'TransfertController@commandes');

// Test
Route::get('test', 'TestController@main');
Route::get('testmail', 'TestController@testmail');


Route::group(['middleware' => 'auth'], function () {

// User...
	Route::resource('user', 'UserController');


// User...
	Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@Main']);


// CLIENT...
	Route::get('client/getdeleted', ['as' => 'client.getdeleted', 'uses' => 'ClientController@getDeleted']);
	Route::resource('client', 'ClientController');
	Route::get('client/setPref/relais', 'ClientController@setPrefRelais');
	Route::get('client/setPref/paiement', 'ClientController@setPrefPaiement');

// ESPACE CLIENT...
	Route::get('espaceclient', ['as' => 'espaceclient', 'uses' => 'EspaceClientController@espaceclient']);


// MODE DE PAIEMENT...
	Route::get('modepaiement/getdeleted', ['as' => 'modepaiement.getdeleted', 'uses' => 'ModePaiementController@getDeleted']);
	Route::get('setrangs/modepaiement', ['as' => 'media.set_rang', 'uses' => 'ModePaiementController@setRangs']);
	Route::get('restore/modepaiement/{id}', ['as' => 'modepaiement.restore', 'uses' => 'ModePaiementController@restore']);
	Route::resource('modepaiement', 'ModePaiementController');



// RELAIS...
	Route::get('relais/getdeleted', ['as' => 'relais.getdeleted', 'uses' => 'RelaisController@getDeleted']);
	Route::get('setrangs/relais', ['as' => 'media.set_rang', 'uses' => 'RelaisController@setRangs']);
	Route::get('restore/relais/{id}', ['as' => 'relais.restore', 'uses' => 'RelaisController@restore']);
	Route::resource('relais', 'RelaisController');

	// Indisponibilité...
	Route::put('relais/handleIndisponibilitiesChanges/{indisponisable_id}',
		['as' => 'relais.handleIndisponibilitiesChanges', 'uses' => 'RelaisController@handleIndisponibilitiesChanges']
		);



// PRODUCTEUR...
	Route::get('producteur/getdeleted', ['as' => 'producteur.getdeleted', 'uses' => 'ProducteurController@getDeleted']);
	Route::get('setrangs/producteur', ['as' => 'media.set_rang', 'uses' => 'ProducteurController@setRangs']);
	Route::get('restore/producteur/{id}', ['as' => 'producteur.restore', 'uses' => 'ProducteurController@restore']);
	Route::resource('producteur', 'ProducteurController');


// PANIER...
	Route::get('panier/getdeleted', ['as' => 'panier.getdeleted', 'uses' => 'PanierController@getDeleted']);
	Route::get('setrangs/panier', ['as' => 'media.set_rang', 'uses' => 'PanierController@setRangs']);
	Route::get('restore/panier/{id}', ['as' => 'panier.restore', 'uses' => 'PanierController@restore']);
	Route::resource('panier', 'PanierController');


// INDISPONIBILITE...
	Route::get('addIndisponibilite/{indisponisable_type}/{indisponisable_id}', ['as' => 'addIndisponibilite', 'uses' => 'IndisponibiliteController@addIndisponibilite']);
	Route::resource('indisponibilite', 'IndisponibiliteController', ['except' => [
		'create'
		]]);

	Route::get('annulationIndisponibilityChanges',
		['as' => 'annulationIndisponibilityChanges', 'uses' => 'IndisponibiliteController@annulationIndisponibilityChanges']
		);


// LIVRAISON...
	Route::get('livraison/combodate/{valeur}', 'LivraisonController@getComboDates');

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

	Route::put('livraison/{livraison}/syncRelaiss',
		['as' => 'livraisonSyncRelaiss', 'uses' => 'LivraisonController@syncRelaiss']
		);

	Route::put('livraison/{livraison}/syncModespaiements',
		['as' => 'livraisonSyncModespaiements', 'uses' => 'LivraisonController@syncModespaiements']
		);

	Route::patch('livraison/archive/{id}',
		['as' => 'livraison.archive', 'uses' => 'LivraisonController@archiver']
		);


	// Pivot Panier / Producteur...
	Route::get('livraison/panier/{panier_id}/listProducteurs',
		['as' => 'listProducteursForPanier', 'uses' => 'LivraisonController@listProducteursForPanier']
		);

	Route::post('panier/{panier_id}/syncProducteurs',
		['as' => 'PanierSyncProducteurs', 'uses' => 'PanierController@syncProducteurs']
		);

// COMMANDE...
	Route::resource('commande', 'CommandeController');

	Route::patch('commande/archive/{id}',
		['as' => 'commande.archive', 'uses' => 'CommandeController@archiver']
		);

	Route::any('toggle/{property}/commande/{id}',
		['as' => 'commande.toggle', 'uses' => 'CommandeController@toggleBooleanProperty']
		);


// DASHBOARD

	Route::resource('livraison', 'LivraisonController');


// ACTIVATION
	Route::any('active/{model_class}/{id}',
		['as' => 'active', 'uses' => 'ActivableController@active']
		);

	Route::any('desactive/{model_class}/{id}',
		['as' => 'desactive', 'uses' => 'ActivableController@desactive']
		);


// Menus...
	Route::resource('menus', '\Menus\MenuController');

});
