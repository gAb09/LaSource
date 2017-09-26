<?php

namespace Menus;

class RoleDomaine {

	public function listRolesForSelect()
	{
		$model = new Role;
		return DomHelper::listForSelect($model, 'etiquette');
	}

}