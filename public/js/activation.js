function active(model_class, id){
	var adresse = 'active/'+model_class+'/'+id;
	console.log('adresse : '+adresse);
	$.ajax({
		url : adresse,
		type : 'GET',
		dataType : 'json',
		success : function(reponse, statut){
			console.log(reponse['statut']);
			console.log(reponse['txt']);
			handleActiveReponse(model_class, id, reponse);
		},

		error : function(resultat, statut, erreur){
			alert(resultat);
            // alert(statut);
            // alert(erreur);
        },

        complete : function(resultat, statut){

        }
    });

	console.log('active : '+model_class+' n° '+id);
}


function desactive(model_class, id){
	var adresse = 'desactive/'+model_class+'/'+id;
	console.log('adresse : '+adresse);
	$.ajax({
		url : adresse,
		type : 'GET',
		dataType : 'json',
		success : function(reponse, statut){
			console.log(reponse['statut']);
			console.log(reponse['txt']);
			handleDesactiveReponse(model_class, id, reponse);
		},

		error : function(resultat, statut, erreur){
			$('#messages').empty().append(resultat);
            // alert(statut);
            // alert(erreur);
        },

        complete : function(resultat, statut){

        }
    });

	console.log('desactive : '+model_class+' n° '+id);
}


function handleActiveReponse(model_class, id, reponse){
	$('#messages').empty().append(reponse['txt']);
	if(reponse['statut'] === true){
		$('#activation_button_'+id).attr('onClick', 'desactive("'+model_class+'", '+id+');');
		$('#activation_icone_'+id).toggleClass('fa-square-o');
		$('#activation_icone_'+id).toggleClass('fa-check-square-o');
		$('#activation_etiquette_'+id).empty().append('Désactiver');
		$('#fiche_'+id).toggleClass('is_actived');
		$('#fiche_'+id).toggleClass('is_not_actived');
	}
}

function handleDesactiveReponse(model_class, id, reponse){
	$('#messages').empty().append(reponse['txt']);
	if(reponse['statut'] === true){
		$('#activation_button_'+id).attr('onClick', 'active("'+model_class+'", '+id+');');
		$('#activation_icone_'+id).toggleClass('fa-square-o');
		$('#activation_icone_'+id).toggleClass('fa-check-square-o');
		$('#activation_etiquette_'+id).empty().append('Activer');
		$('#fiche_'+id).toggleClass('is_actived');
		$('#fiche_'+id).toggleClass('is_not_actived');
	}
}
