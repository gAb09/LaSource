$("#paniers_index").sortable({
	update: function(event, ui){
	// Actualiser la page 
		// Lister les éléments "sortable"
		list = ui.item.parent('div#paniers_index');

		pos = 0;
		var tablo = [];
		// Actualiser les rangs de chaque éléments "sortable"
		list.find('p.rang').each(function(){
			pos++;
			$(this).html('Rang : '+pos);

			// Récupérer les panier_id de chaque éléments "sortable"
			var panier_id = $(this).siblings('p.id').html();

			// Ajouter au tableau qui sera envoyé au script php
			doublet = [panier_id, pos];
						console.log('panier_id : '+ panier_id);

			tablo.push(doublet);

		});
			// console.log('tablo sortie boucle : '+tablo);
		setRangs('panier', tablo);

	}
});



function editPanier(panier_id){
	// console.log(domaine);
	// console.log(panier_id);

	document.location.href='http://'+domaine+'/panier/'+panier_id+'/edit';
}