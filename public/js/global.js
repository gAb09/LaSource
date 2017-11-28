var domaine = document.domain;
console.log(domaine);


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


function toggleBooleanIcone(zis)
{
	var icone = $(zis).children("i");

	console.log('zis : '+zis);
	console.log('icone : '+icone);

	$(icone).toggleClass('fa-check-square');
	$(icone).toggleClass('fa-square-o');
}