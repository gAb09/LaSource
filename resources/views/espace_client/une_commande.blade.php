	<h4 class="titre">Commande du {{ $commande->Livraison->date_livraison_enClair }} <small>(numéro {{ $commande->numero }})</small></h4>
	<p class="statut">{{ trans('constante.'.$commande->statut) }}</p>

	

	<table class="index_commandes_espaceclient">
		<tbody>
			@foreach($commande->lignes as $ligne)
			@include("commande.ligne")
			@endforeach
			<tr class="total">
				<td colspan="3">
					@if($commande->statut == 'C_CREATED' or $commande->statut == 'C_REGISTERED')
						<div class="btn btn-primary btn-xs" onClick="alert('Modifier la commande '+{{$commande->id}})" >Modifier cette commande</div>
                    @endif
				</td>
				<td colspan="2">
					TOTAL :
				</td>
				<td>
					{{ $commande->montant_total }}
				</td>
			</tr>
		</tbody>
	</table>
	<div>
		Relais : {{ $commande->relais->nom }} – Paiement par {{ $commande->modepaiement->nom }}<br />
	</div>