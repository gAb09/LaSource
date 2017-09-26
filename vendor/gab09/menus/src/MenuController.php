<?php
namespace Menus;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Routing\Controller as BaseController;
// use Illuminate\View\View as View;

class MenuController extends BaseController {
// aFa Faire les validations
	
	protected $validateur;

	public function __construct()
	{
		// $this->validateur = $validateur;
		$this->menuDom = new MenuDomaine;
		//$this->roleDom = new RoleDomaine;
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		$menus = Menu::with('role')->orderBy('parent_id')->orderBy('rang')->get();

		return view('menus::index')
		->with(compact('menus'))
		->with('titre_page', "Gestion des menus")
		;
	}



	public function create() {
		// return 'create menu';
		$menu = $this->menuDom->create();

		return View::make('menus.views.create')
		->with(compact('menu'))
		->with('titre_page', "Création d’un menu ou d’un item")
		->with('list_roles', $this->roleDom->listRolesForSelect())
		->with('list_menus', $this->menuDom->listRolesForSelect())
		;
	}



	public function store() {
		// return 'Store un nouveau "Menu"';

// dd(Input::all()); // CTRL
		$publication = (Input::get('publication')) ? 1 : 0;
		$menu = Menu::create(array(
			'etiquette' => Input::get('etiquette'),
			'nom_sys' => Input::get('nom_sys'),
			'publication' => $publication,
			'rang' => Input::get('rang'),
			'route' => Input::get('route'),
			'role_id' => Input::get('role_id'),
			'description' => Input::get('description') ? Input::get('description') : 'Sans description',
			));

		$parent_id = (Input::get('parent_id'));

		if ($parent_id != 0) {
			$menu->makeChildOf(Menu::findOrFail($parent_id));
		}

		return Redirect::action('MenuController@index');
	}



	public function edit($id) {
		// return 'Edition du Menu n°'.$id;

		$menu = Menu::with('role')->first()->findOrFail($id);
		// var_dump($menu); // CTRL

		return View::make('menus.views.edit')
		->with(compact('menu'))
		->with('titre_page', "Modification de l’item ou du menu")
		->with('list_roles', $this->roleDom->listRolesForSelect())
		->with('list_menus', $this->menuDom->listRolesForSelect())
		;
	}



	public function update($id) {
		// return "Alors tu l'update ton menu n° $id";

		// dd(Input::all()); //CTRL

		$menu = Menu::find($id);

		$menu->nom_sys = Input::get('nom_sys');
		$menu->etiquette = Input::get('etiquette');
		$menu->publication = Input::get('publication');
		$menu->rang = Input::get('rang');
		$menu->route = Input::get('route');
		$menu->description = Input::get('description');
		$menu->role_id = Input::get('role_id');

		$parent_id = (Input::get('parent_id'));

		if ($parent_id != 0) {
			$menu->makeChildOf(Menu::findOrFail($parent_id));
		}else{
			if ($menu->parent_id !== null) {
			$menu->makeRoot();
			}
		}

		$menu->save();

		// return var_dump($menu); //CTRL
		return Redirect::action('MenuController@index');
	}



	public function destroy($id) {
		// return 'Suppression de l’item ou du menu n°'.$id;

		$menu = Menu::FindOrFail($id);

		$desc = $menu->getDescendants();

		if ($desc->count()) {
			return Redirect::to('menus')->withErrors('L’item “'.$menu->etiquette.'” possède des descendants, 
				veuillez d‘abord les déplacer ou les supprimer.');
		} else {
			$menu->delete();
			Session::flash('success', 'L’item "'.$menu->etiquette.'" a bien été supprimé');
			return Redirect::to('menus');
		}

	}

}

