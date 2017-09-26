<?php

namespace Menus;

class MenuDomaine {

	protected  $default_values_for_create = [
    'nom_sys' => 'Saisir un nom “système”',
    'publication' => 0,
    //'description' => CREATE_FORM_DEFAUT_TXT_DESCRIPTION,
    ];


	public function create()
	{
		return new Menu($this->default_values_for_create);
	}

	public function listRolesForSelect()
	{
		return Menu::listForInputSelect('etiquette');
	}

}