/* --------------------------------------------------------------
Gestion de la sélection des modes de paiement et des relais + valeurs par défaut + report dans formulaire.
----------------------------------------------------------------*/

function becomeSelected(item, id){
	var livraison = $(item).attr('livraison');
	var model = $(item).attr('model');
	var nom_item = $(item).attr('name');

	to_uncheck = $("span[livraison="+livraison+"][model="+model+"]");

	console.log('item : '+item);
	console.log('livraison : '+livraison);
	console.log('nom_item : '+nom_item);
	//console.log('to_uncheck : '+$(to_uncheck).length);

	/* On décoche tous les boutons de ce model pour cette livraison + on coche ce bouton  */
	$(to_uncheck).removeClass('checked');
	$(item).addClass('checked');

	/* Si l'id de la livraison est 0 c'est que nous ne sommes pas dans le cadre d'une livraison mais dans celui du réglage des préférences par défaut, 
	donc il faut persister ce choix en BDD + le reporter immédiatement sur toutes les livraisons actuellement affichées.
	Si l'id désigne une livraison on actualise l'input associé.
	Et dans les 2 cas on avertit qu'il y a eu un changement sur la page */
	if (livraison === '0') {
		persisterParametres(id, model);
		reporterValeurDefaut(model, nom_item, id);
		changementDetected();
	}else{
		updateAssociatedInput(livraison, model, id);
		changementDetected();
	}
}


/**
* Persister l'id du model en BDD, table client, colonne pref_relais ou pref_mode.
* 
* @arguments : id, model.
**/
function persisterParametres(id, model) {

	console.log('model : '+model);
	console.log('id : '+id);

	var ad = 'http://'+domaine+'/client/setPref/'+model;

	$.ajax({
		url : ad,
		contentType : 'text/json',
		type : 'GET',
		data : {'id' : id},
		dataType : 'html',
		success : function(code_html, data, statut){
			console.log(code_html);
			$('#messages').empty().append(code_html);
		},

		error : function(data, resultat, statut, erreur){
			console.log(data);
			console.log(resultat);
			console.log(statut);
			console.log(erreur);
		},

	});

}



function reporterValeurDefaut(model, nom_item, valeur){
	//console.log('reporterValeurDefaut');
	var tous_les_models = $("[model='"+model+"']");
	var models_du_meme_nom = $("[name='"+nom_item+"']");

	$(tous_les_models).each(function(index){
		//console.log($(this).attr('livraison'));
		$(this).removeClass('checked');
	});

	$(models_du_meme_nom).each(function(index){
		//console.log($(this).attr('livraison'));
		updateAssociatedInput($(this).attr('livraison'), model, valeur);
		$(this).addClass('checked');
	});
}



function updateAssociatedInput(livraison, model, valeur) {
	var input = $("[name="+livraison+"_"+model+"]");
	$(input).val(valeur);
	//console.log("input vaut : "+$(input).val());
}



/* --------------------------------------------------------------
Gestion de l'incrémentation/décrémentation des quantités des paniers.
----------------------------------------------------------------*/

function increment(livraison, panier) {
	var c = getContextPanierChange(livraison, panier);
	var qte_panier_cible = c.qte_panier_cible();
	
	sanitizeInputValue(qte_panier_cible);

	qte_panier_cible.value++;

	ActualiserQtePanier(c, qte_panier_cible.value);
	ActualiserTotalPanier(c);
	ActualiserTotalLivraison(c);

	changementDetected();
}

function decrement(livraison, panier) {
	var c = getContextPanierChange(livraison, panier);
	var qte_panier_cible = c.qte_panier_cible();

	sanitizeInputValue(qte_panier_cible);

	if (qte_panier_cible.value >0) {
		qte_panier_cible.value--;

		ActualiserQtePanier(c, qte_panier_cible.value);
		ActualiserTotalPanier(c);
		ActualiserTotalLivraison(c);

		changementDetected();
	}
}


function qteChange(input, livraison, panier){
	var c = getContextPanierChange(livraison, panier);
	
	if (input.value < 0) {
		input.focus();
		alert('Vous ne pouvez pas saisir des valeurs négatives');
		return;
	}

	if(isNaN(input.value)){
		input.focus();
		alert('Vous ne pouvez saisir que des chiffres');
		return;
	}

	ActualiserQtePanier(c, input.value);
	ActualiserTotalPanier(c);
	ActualiserTotalLivraison(c);

	changementDetected();
}


function getContextPanierChange(livraison, panier){
	var contexte = {
		livraisonId :livraison,
		panierId : panier,
		qte_panier : 0,
		qte_panier_cible : function() {return $("[name='" + this.livraisonId + "_qte_"+this.panierId+"']").get(0);},
		prix_panier : function() {return $("[name='" + this.panierId + "_prix_panier']").get(0).innerHTML;},
		total_panier_cible : function() {return $("[name='" + this.livraisonId + "_total_panier_" + this.panierId + "']").get(0);},
		total_livraison_cible : function() {return $("[name='" + this.livraisonId + "_total_livraison']").get(0);},
		all_totaux_panier : function() {return $("p[name^='" + this.livraisonId + "_total_panier_']");},
	};
	console.log('livraisonId : '+contexte.livraisonId);
	console.log('panierId : '+contexte.panierId);
	console.log('qte_panier : '+contexte.qte_panier);
	console.log('qte_panier_cible : '+contexte.qte_panier_cible().length);
	console.log('prix_panier : '+contexte.prix_panier());
	console.log('total_panier_cible : '+contexte.total_panier_cible().length);
	console.log('total_livraison_cible : '+contexte.total_livraison_cible().name);
	console.log('all_totaux_panier : '+contexte.all_totaux_panier().length);
	return contexte;
}


function ActualiserQtePanier(c, qte_panier){
	c.qte_panier = qte_panier;
	c.qte_panier_cible().innerHTML = qte_panier;
}

function sanitizeInputValue(input){
	if(isNaN(input.value) || input.value <= 0){
		input.value = 0;
	}
}


function ActualiserTotalPanier(c){
	c.total_panier_cible().innerHTML = 'Total panier : <span>'+c.qte_panier*c.prix_panier()+'</span> euros';
	/* Le span à pour but d'isoler le nombre significatif de tout texte, puisqu'il entrera dans le calcul du total livraison */
}


function ActualiserTotalLivraison(c){
	var collection = c.all_totaux_panier();
	console.log('calculTotalLivraison');
	nbre = collection.length;
	var total = 0;
	for (i = 0 ; i < nbre ; i++) {
		if(collection[i].childNodes[1] !== undefined){
			total += parseFloat(collection[i].childNodes[1].innerHTML);
		}
	}
	c.total_livraison_cible().innerHTML = "Total livraison : "+total+" euros";

}

/* --------------------------------------------------------------
Global.
-----------------------------------------------------------------*/

function changementDetected(){
	if ($("#commande_store").children('button').length === 0) {
		$("#commande_store").append('<button type="submit" class="btn btn-success" style="float:right;">'+
			'Vous êtes en train de faire des changements, une fois ceux-ci terminés, cliquez sur cette barre pour les valider</button>');
	}

}

function toggleCommandesArchived(){
$('#une_commande_archive').toggleClass('hidden');
$('#show_commandes_archived').toggleClass('hidden');
$('#hide_commandes_archived').toggleClass('hidden');
}
