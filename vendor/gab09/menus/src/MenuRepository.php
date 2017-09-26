<?php

class MenuRepository {

	public function listRolesForSelect()
	{
		return Menu::listForInputSelect('etiquette');
	}

}