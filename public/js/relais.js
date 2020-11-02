/**
*
*
* Call setRangs dans global.js
* @arguments : string : nom du model / json array : doublets (id: rang)
**/
$("#relaiss_index").sortable({
	update: function(event, ui){
	// Actualiser la page
		// Lister les éléments "sortable"
		list = ui.item.parent('div#relaiss_index');

		pos = 0;
		var tablo = [];
		// Actualiser les rangs de chaque éléments "sortable"
		list.find('p.rang').each(function(){
			pos++;
			$(this).html('Rang : '+pos);

			// Récupérer les relais_id de chaque éléments "sortable"
			var relais_id = $(this).siblings('p.id').html();

			// Ajouter au tableau qui sera envoyé au script php
			doublet = [relais_id, pos];
						console.log('relais_id : '+ relais_id);

			tablo.push(doublet);

		});
			console.log('tablo sortie boucle : '+tablo);
		setRangs('relais', tablo);

	}
});


function editRelais(relais_id){
	// console.log(domaine);
	// console.log(relais_id);

	document.location.href = domaine+'/relais/'+relais_id+'/edit';
}
