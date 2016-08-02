/**
* 
* 
* Call setRangs dans global.js
* @arguments : string : nom du model / json array : doublets (id: rang)
**/
$("#producteurs_index").sortable({
	update: function(event, ui){
	// Actualiser la page 
		// Lister les éléments "sortable"
		list = ui.item.parent('div#producteurs_index');

		pos = 0;
		var tablo = [];
		// Actualiser les rangs de chaque éléments "sortable"
		list.find('p.rang').each(function(){
			pos++;
			$(this).html('Rang : '+pos);

			// Récupérer les producteur_id de chaque éléments "sortable"
			var producteur_id = $(this).siblings('p.id').html();

			// Ajouter au tableau qui sera envoyé au script php
			doublet = [producteur_id, pos];
						console.log('producteur_id : '+ producteur_id);

			tablo.push(doublet);

		});
			console.log('tablo sortie boucle : '+tablo);
		setRangs('producteur', tablo);

	}
});

