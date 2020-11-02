$("#modepaiements_index").sortable({
	update: function(event, ui){
	// Actualiser la page
		// Lister les éléments "sortable"
		list = ui.item.parent('div#modepaiements_index');

		pos = 0;
		var tablo = [];
		// Actualiser les rangs de chaque éléments "sortable"
		list.find('p.rang').each(function(){
			pos++;
			$(this).html('Rang : '+pos);

			// Récupérer les model_id de chaque éléments "sortable"
			var model_id = $(this).siblings('p.id').html();

			// Ajouter au tableau qui sera envoyé au script php
			doublet = [model_id, pos];
						console.log('model_id : '+ model_id);

			tablo.push(doublet);

		});
			console.log('tablo sortie boucle : '+tablo);
		setRangs('modepaiement', tablo);

	}
});



function editModePaiement(modepaiement_id){
	console.log(modepaiement_id);
	console.log(domaine);

	document.location.href = domaine+'/modepaiement/'+modepaiement_id+'/edit';
}
