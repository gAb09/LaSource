function afficherAllLivraisons()
{
	var alldiv = $("div[role='rapport']");
	var handle_one_livraison = $("small[role='handleOneLivraison']");
	var handle_all_livraisons = $("small[role='handleAllLivraisons']");

	console.log('alldiv : '+alldiv);
	console.log('handle_one_livraison : '+handle_one_livraison);


	alldiv.each(function(index){
		$(this).removeClass('hidden');
	});

	$(handle_one_livraison).each(function(index){
		$(this).removeClass('afficher');
		$(this).addClass('masquer');
	});

	$(handle_all_livraisons).addClass('hidden');
}

function afficherMasquerUneLivraison(zis, livraison_id)
{
	console.log('zis : '+zis);
	console.log('livraison_id : '+livraison_id);
	var handle_all_livraisons = $("small[role='handleAllLivraisons']");
	var handle_one_livraison = $("small[role='handleOneLivraison']");

	console.log('handle_all_livraisons : '+handle_all_livraisons);
	console.log('handle_one_livraison : '+handle_one_livraison);

	$('#'+livraison_id).toggleClass('hidden');

	$(zis).toggleClass('afficher');
	$(zis).toggleClass('masquer');

	$(handle_all_livraisons).addClass('hidden');
	$(handle_one_livraison).each(function(index){
		if ($(this).hasClass('afficher')) {
			$(handle_all_livraisons).removeClass('hidden');
		}
	});

}

function afficherMasquerPartie(zis, partie)
{
	console.log(partie);
	var handleParties = $("[role="+partie+"]");

	if ($(zis).hasClass('afficher')) {
		$(zis).removeClass('afficher');
		$(zis).addClass('masquer');
		$(handleParties).each(function(index){
			$(this).removeClass('hidden');
		});
	}else{
		$(zis).removeClass('masquer');
		$(zis).addClass('afficher');
		$(handleParties).each(function(index){
			$(this).addClass('hidden');
		});
	}
}
function updateStatutCommande(commande_id)
{
	var adresse = '/commande/updateStatut/'+commande_id;
	var td_statut = $("#statut_"+commande_id);

	console.log('adresse : '+adresse);
	console.log('commande_id : '+$(commande_id));
	console.log('td_statut : '+td_statut);

	$.ajax({
		url : adresse,
		type : 'GET',
		dataType : 'json',
		success : function(reponse, statut){
			if(reponse['statut'] === true){
				$(td_statut).empty().append(reponse['txt']);
			}else{
				$('#messages').empty().append(reponse['txt']);
			}
			// console.log(reponse['statut']);
			// console.log(reponse['txt']);
		},

		error : function(resultat, statut, erreur){
			$('#messages').empty().append('tralala');
			console.log('resultat : '+resultat);
			console.log('statut : '+statut);
			console.log('erreur : '+erreur);
		},

		complete : function(resultat, statut){

		}
	});

}
