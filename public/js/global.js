var domaine = document.domain;
console.log(domaine);

/**
* Disponible pour tous les models.
* Change la présentation (CSS) des éléments relatifs à is_actived.
* 
* 
**/
function handleIsActivedClass()
{
	var item = $('.toggle_actived');
	console.log(item);

	$(item).toggleClass('is_not_actived').toggleClass('is_actived');
}



/**
* Disponible pour tous les models.
* Accède à l'API Laravel pour mettre à jour le nouvel ordre des models.
* Appelé par le script de l'élément draggable qui doit fournir les arguments
* 
* @param model : modèle concerné
* @param tablo : tablo de doublets [model_id, position après drop]
* 
* @return string|null : contenu html pour les messages utilisateurs
**/
function setRangs(model, tablo){
// console.timeStamp();
	/* console.log('model : '+model); */
	/* console.log('tablo : '+tablo); */

	var ad = 'setrangs/'+model;
	$.ajax({
		url : ad,
		contentType : 'text/json',
		type : 'GET',
		data : {'tablo' : tablo},
		dataType : 'html',
		success : function(code_html, data, statut){
			console.log(code_html);
			$('#messages').empty().append(code_html);
		},

		error : function(data, resultat, statut, erreur){
			$('#messages').empty().append('tralala');
			console.log(data);
			console.log(resultat);
			console.log(statut);
			console.log(erreur);
		},

	});

}


/**
* ??????????????????
* Affiche les mode d'emploi.
* 
* 
**/
function showModemploi()
{
	var item = $('#modemploi');
	console.log(item);

	$(item).toggleClass('open');
}


function addIndisponibilite(route)
{
	console.log(route);
	document.location.href = route;
}
