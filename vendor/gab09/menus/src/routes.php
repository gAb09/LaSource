<?php

	// use MenuController;

	/*----------------------  Menus  ----------------------------------*/
Route::group(array('prefix' => 'admin', 'before' => array('auth', 'admin')), function() 
{
	Route::get('/', function(){
		// return Redirect::to('admin/menus');
	});

	Route::resource('menus', 'Menus\MenuController');
	
});