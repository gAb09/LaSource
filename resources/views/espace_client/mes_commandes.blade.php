@if($model->Client->Commandes->isEmpty())
	Pas de commande
@else
	@foreach($model->Client->Commandes as $commande)
	<div class="ma_commande" style="position:relative">
		<h4 class="titre">Commande pour le {{ $commande->Livraison->date_livraison_enClair }} <small>(commande {{ $commande->numero }})</small></h4>
		<p class="statut">{{ $commande->statut }}</p>

		

		<table class="index_commandes_espaceclient">
			<tbody>
				@foreach($commande->lignes as $ligne)
					@include("commande.ligne")
				@endforeach
				<tr class="total">
					<td colspan="5">TOTAL :
					</td>
					<td>
						{{ $commande->montant_total }}
					</td>
				</tr>
			</tbody>
		</table>
		Relais : {{ $commande->relais->nom }} – Paiement par {{ $commande->modepaiement->nom }}<br />
</div>
	@endforeach
@endif

