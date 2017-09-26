<?php
// aFa  décomposer en plusieurs viewcomposer ?

/* Composition du menu principal */
View::composer(array('menus/views/menuSections'), function($view) {
	
	$sections = Menu::where('publication', 1)->whereNull('parent_id')->orderBy('rang')->get();

	$view->with(compact('sections'));
});


/* Composition du sous-menu modes*/
View::composer(array('tresorerie/views/modes'), function($view) {


	$mode = Menu::where('nom_sys', 'tresorerie_modes')->get();
	$modes = Menu::where('parent_id', $mode[0]->id)->get();

	$view->with(compact('modes'));
});


/* Composition du sous-menu configuration*/
View::composer(array('tresorerie/views/configuration'), function($view) {


	$config = Menu::where('nom_sys', 'tresorerie_configuration')->get();
	$configs = Menu::where('parent_id', $config[0]->id)->get();

	$view->with(compact('configs'));
});

/* Composition du sous-menu */
View::composer(array('menus/views/menus'), function($view) {


	$section = Menu::where('nom_sys', Request::segment(1))->get();
	$menus = Menu::where('parent_id', $section[0]->id)->get();

	$view->with(compact('menus'));
});





View::composer('tresorerie/views/ecritures/form', function($view)
{
	/* Lister les séparateurs pour le javascript */
	$types = Type::all();

	/* Composer les input radios pour le signe */
	foreach(Signe::all() as $item)
	{
		$list_radios[$item->id]['id'] = 'id';
		$list_radios[$item->id]['name'] = 'signe';
		$list_radios[$item->id]['value'] = $item->id;
		$list_radios[$item->id]['etiquette'] = $item->etiquette;
		$list_radios[$item->id]['id_css'] = 'signe_'.$item->id;
		$list_radios[$item->id]['fonction_js'] = $item->etiquette.'();';
	}

	$view->with(compact('types'))->with(compact('list_radios'));
});


?>