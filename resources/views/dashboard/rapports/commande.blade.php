<h4>Détail des commandes</h4>


<table class="commande" style="width:100%">
	<thead>
		<tr>
			<th class="">Commande</th>
			<th class="">Client</th>
			<th class="">Mode paiement</th>
			<th class="">Relais</th>
			<th class="">Panier</th>
			<th class="">Quantité</th>
			<th class="">Payée</th>
			<th class="">Livrée</th>
			<th class="">Retirée</th>
		</tr>
	</thead>
	<tbody>
		@foreach($commandes as $commande)
			<?php 
			$rowspan = $commande->lignes->count();
			?>
			
			<tr>
				<td rowspan ="{{$rowspan}}" class="" >n° {{$commande->numero}}<br />du @date_eB($commande->created_at)</td>
				<td rowspan ="{{$rowspan}}" class="" >{{$commande->client->nom_complet}}</td>
				<td rowspan ="{{$rowspan}}" class="" >{{$commande->modepaiement->nom}}</td>
				<td rowspan ="{{$rowspan}}" class="" >{{$commande->relais->nom }}</td>
				<td class="" >{{$commande->lignes[0]->panier_type }} — {{$commande->lignes[0]->panier_nom }}</td>
				<td class="" >{{$commande->lignes[0]->quantite}}</td>
				<td rowspan ="{{$rowspan}}" class="" >{{$commande->is_paid}}</td>
				<td rowspan ="{{$rowspan}}" class="" >{{$commande->is_livred}}</td>
				<td rowspan ="{{$rowspan}}" class="" >{{$commande->is_retired}}</td>
			</tr>
			@for ($i = 1; $i < $rowspan; $i++)
			<tr>
				<td class="" >{{$commande->lignes[$i]->panier_type }} — {{$commande->lignes[$i]->panier_nom }}</td>
				<td class="" >{{$commande->lignes[$i]->quantite}}</td>
			</tr>
			@endfor
		@endforeach
	</tbody>
</table>