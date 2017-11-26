<h3>Détail des commandes</h3>


<table class="" style="width:100%">
	<thead>
		<tr>
			<th class="commande">
				Commande
			</th>
			<th class="surligned">
				Client
			</th>
			<th class="">
				Mode paiement
			</th>
			<th class="">
				Relais
			</th>
			<th class="surligned">
				Panier
			</th>
			<th class="surligned">
				Quantité
			</th>
			<th class="commande">
				Payée
			</th>
			<th class="commande">
				Livrée
			</th>
			<th class="commande">
				Retirée
			</th>
			<th class="commande">
				Statut
			</th>
		</tr>
	</thead>
	<tbody>
		@foreach($commandes as $commande)
		<?php 
		$rowspan = $commande->lignes->count();
		?>

		<tr>
			<td rowspan ="{{$rowspan}}" class="commande" >
				n° {{$commande->numero}}<br />du @date_eB($commande->created_at)
			</td>
			<td rowspan ="{{$rowspan}}" class="surligned" >
				{{$commande->client->nom_complet}}<br/>{{$commande->client->tel}}
			</td>
			<td rowspan ="{{$rowspan}}" class="modepaiement" >
				{{$commande->modepaiement->nom}}
			</td>
			<td rowspan ="{{$rowspan}}" class="relais" >
				<small>{{$commande->relais->ville }}</small><br />{{$commande->relais->nom }}
			</td>
			<td class="surligned" >
				<small>{{$commande->lignes[0]->panier_type }}</small> - {{$commande->lignes[0]->panier_nom }}
			</td>
			<td class="surligned" >
				{{$commande->lignes[0]->quantite}}
			</td>
			<td rowspan ="{{$rowspan}}" class="commande">
				<div style="display:inline" onClick="javascript:updateStatutCommande({{$commande->id}})">
					@include('dashboard.rapports.booleen', ['valeur' => $commande->is_paid, 'model' => 'commande', 'id' => $commande->id, 'property' => 'is_paid'])
				</div>
			</td>
			<td rowspan ="{{$rowspan}}" class="commande" >
				@include('dashboard.rapports.booleen', ['valeur' => $commande->is_livred, 'model' => 'commande', 'id' => $commande->id, 'property' => 'is_livred'])
			</td>
			<td rowspan ="{{$rowspan}}" class="commande" >
				@include('dashboard.rapports.booleen', ['valeur' => $commande->is_retired, 'model' => 'commande', 'id' => $commande->id, 'property' => 'is_retired'])
			</td>
			<td rowspan ="{{$rowspan}}" id="statut_{{$commande->id}}" class="commande" >
					{{trans('statuts.'.$commande->statut)}}
					@if($commande->statut == 'C_NONPAID')
					<a class="close" title="Envoyer mail de relance au client {{$commande->client->id}}" href="" onClick="javascript:alert('Envoyer mail de relance au client {{$commande->client->id}}'))">
						<i class="btn_close fa fa-btn fa-mail-forward" style="font-size:0.6em"></i>
					</a>
					@endif
			</td>
		</tr>
		@for ($i = 1; $i < $rowspan; $i++)
		<tr>
			<td class="surligned" >
				<small>{{$commande->lignes[$i]->panier_type }}</small> - {{$commande->lignes[$i]->panier_nom }}
			</td>
			<td class="surligned" >
				{{$commande->lignes[$i]->quantite}}
			</td>
		</tr>
		@endfor
		@endforeach
	</tbody>
</table>