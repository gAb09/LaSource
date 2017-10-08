<h3>Mes commandes</h3>
@if($model->Client->Commandes->isEmpty())
	Pas de commande
@else
	@foreach($model->Client->Commandes as $commande)
		<h4>Livraison du {{ $commande->Livraison->date_livraison_enClair }} <small>(commande {{ $commande->numero }})</small></h4>

		
		Relais : {{ $commande->relais->nom }}<br />
		Paiement par {{ $commande->modepaiement->nom }}<br />

		@foreach($commande->lignes as $ligne)
		<table>
			<thead>
			</thead>
			<tbody>
				<tr style="border-top: 1px dashed red;">
					<td>
						{!! $ligne->panier->type !!} {!! $ligne->panier->nom_court !!}
					</td>
					<td>
						{{ $ligne->quantite }}
					</td>
					<td>
						 x {{ $ligne->complement->prix_livraison }}
					</td>
					<td>
						 = {{ $ligne->montant_ligne }} 
					</td>
				</tr>
				<tr>
				</tr>
			</tbody>
		</table>
		@endforeach
		{{ $commande->montant_total }}
	@endforeach
@endif