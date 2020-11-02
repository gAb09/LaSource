/* --------------------------------------------------------------
Gestion de la sélection des modes de paiement et des relais + valeurs par défaut + report dans formulaire.
----------------------------------------------------------------*/
function becomeSelected(item, id){
	var livraison = $(item).attr('livraison');
	var model = $(item).attr('model');
	var nom_item = $(item).attr('name');

	var to_uncheck = $("span[livraison="+livraison+"][model="+model+"]");

	console.log('item : '+item); // span cliqué
	console.log('id item cliqué : '+id);  // id du relais ou du mode de paiement cliqué
	console.log('livraison : '+livraison);  // id de la livraison (0 si partie préférences utilisateur)
	console.log('nom_item : '+nom_item); // nom du relais ou du mode de paiement cliqué
	console.log('to_uncheck : '+$(to_uncheck).length);

	/* On modifie l'affichage :
	– décocher tous les boutons de ce model pour cette livraison
	– cocher le bouton du model sélectionné  */
	$(to_uncheck).removeClass('checked');
	$(item).addClass('checked');


	if (livraison === '0') {
		/* Si l'id de la livraison est 0 c'est que nous ne sommes pas dans le cadre d'une livraison
		mais dans celui du réglage des préférences par défaut.
		– persister ce choix en BDD (table client)
		– masquer le message indiquant qu'il n'y a pas de choix par défaut (pour ce model)
		*/
		persisterParametresParDefaut(id, model);
		MasquerMessageAucunChoixParDefaut(model);
	}else{
		/*
		Si l'id désigne une livraison
		– avertir qu'il y a eu un changement sur la commande et qu'il faudra valider.
		– persister ce choix en BDD (table commande)
		*/
		signalerChangement();
		updateAssociatedInput(livraison, model, id);
	}
}


/**
* Persister l'id du model (Mode paiement ou Relais) en BDD, table client, colonne pref_relais ou pref_mode.
*
* @arguments : id, model.
**/
function persisterParametresParDefaut(id, model) {

	// console.log('model : '+model);
	// console.log('id : '+id);

	var ad = domaine+'/client/setPref/'+model;

	$.ajax({
		url : ad,
		contentType : 'text/json',
		type : 'GET',
		data : {'id' : id},
		dataType : 'html',
		success : function(code_html, data, statut){
			// console.log(code_html);
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



/**
* Masque le message indiquant qu'il n'y a pas de choix par défaut.
*
* @arguments : model (Relais || Mode de paiement)
**/
function MasquerMessageAucunChoixParDefaut(model) {
		var alert_nopref = $("p[role='nopref'][model='"+model+"']");
		$(alert_nopref).addClass('hidden');
	}


	// function handleAlerFavNotLied(model, id) {
	// 	var all_fav_not_lied = $("p[role='fav_not_lied'][model='"+model+"']");
	// 	console.log('model : '+model);
	// 	console.log('all_fav_not_lied : '+all_fav_not_lied.length);
	//
	// 	all_fav_not_lied.each(function(index){
	// 		console.log('this :'+$(this).attr('livraison'));
	// 		var livraison_id = $(this).attr('livraison');
	// 		var tablo;
	// 		if (model === 'relais') {
	// 			tablo = relais_lied[livraison_id];
	// 		}
	// 		if (model === 'paiement') {
	// 			tablo = paiement_lied[livraison_id];
	// 		}
	// 		console.log('livraison_id : '+livraison_id);
	// 		console.log('tablo : '+tablo);
	// 		console.log('id critere : '+id);
	//
	// 		var a = tablo.indexOf(id);
	// 		if (livraison_id !== 0) {
	// 			if (a === -1) {
	// 				console.log('favori absent - '+model);
	// 				// alert('favori absent - '+model);
	// 				$(this).removeClass('hidden');
	// 			}else{
	// 				// alert('favori présent - '+model);
	// 				console.log('favori présent - '+model);
	// 				$(this).addClass('hidden');
	// 			}
	// 		}
	//
	// 	});
	//
	// }




	function updateAssociatedInput(livraison, model, valeur) {
		var input = $("[name="+livraison+"_"+model+"]");
		$(input).val(valeur);
	console.log("L’input "+$(input).attr('name')+" vaut : "+$(input).val());
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

	signalerChangement();
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

		signalerChangement();
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

	signalerChangement();
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
	// console.log('livraisonId : '+contexte.livraisonId);
	// console.log('panierId : '+contexte.panierId);
	// console.log('qte_panier : '+contexte.qte_panier);
	// console.log('qte_panier_cible name : '+contexte.qte_panier_cible().getAttribute('name'));
	// console.log('prix_panier : '+contexte.prix_panier());
	// console.log('total_panier_cible : '+contexte.total_panier_cible().getAttribute('name'));
	// console.log('total_livraison_cible : '+contexte.total_livraison_cible().getAttribute('name'));
	// console.log('all_totaux_panier : '+contexte.all_totaux_panier().length);
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
	// console.log('ActualiserTotalPanier');
	c.total_panier_cible().innerHTML = 'Total panier : <span>'+c.qte_panier*c.prix_panier()+'</span> euros';
	/* Le span à pour but d'isoler le nombre significatif de tout texte, puisqu'il entrera dans le calcul du total livraison */
}


function ActualiserTotalLivraison(c){
	var collection = c.all_totaux_panier();
	// console.log('calculTotalLivraison');
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

function signalerChangement(){
	$("#change_detected").removeClass('hidden');
	// if ($("#modification_livraison").html() === '') {
	// 	$("#change_detected").removeClass('hidden');
	// }

}

function toggleCommandesArchived(){
	$('#une_commande_archived').toggleClass('hidden');
	$('#show_commandes_archived').toggleClass('hidden');
	$('#hide_commandes_archived').toggleClass('hidden');
}


function editCommande(commande_id, livraison_id){
	console.log('commande n° '+commande_id);
	console.log('livraison_id : '+livraison_id);
	console.log('domaine : '+domaine);
	var adresse = 'commande/'+commande_id+'/edit';
	console.log(adresse);


	$.ajax({
		url : adresse,
		type : 'GET',
		dataType : 'html',
		success : function(data, statut){
			$('#livraison_modified').empty().append(data);

			$('#modification_livraison').empty().html('Modification de la ');

			$('#commande_update').attr('action', domaine+"/commande/"+commande_id);


			all_qte_panier = $("[name^='" + livraison_id + "_qte']");
			all_qte_panier.each(function(index){
				var panier_id = this.name.replace(livraison_id + '_qte_', '');
				// console.log(panier_id+" : "+this.name+" vaut : "+this.value);
				if (this.value !== 0) {
					var c = getContextPanierChange(livraison_id, panier_id);
					// console.log('Quantité : '+this.value);
					c.qte_panier = this.value;

					ActualiserTotalPanier(c);
					ActualiserTotalLivraison(c);
				}
			});

		},

		error : function(resultat, statut, erreur){
            // alert(resultat);
            // alert(statut);
            // alert(erreur);
        },

        complete : function(resultat, statut){

        }
    });
    // var c = getContextPanierChange(livraison_id, panier_id);
	// ActualiserTotalPanier(c);
	// ActualiserTotalLivraison(c);

}
