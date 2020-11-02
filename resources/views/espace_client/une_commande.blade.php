	<h4 class="titre">Commande sur la livraison du @date_complete($commande->Livraison->date_livraison) <small>(numéro {{ $commande->numero }})</small></h4>
	<p class="statut">{{ trans('statuts.'.$commande->statut) }}</p>

	

	<table class="index_commandes_espaceclient">
		<tbody>
			@foreach($commande->lignes as $ligne)
			@include("commande.ligne")
			@endforeach
			<tr class="total">
				<td colspan="3">
					@if($commande->statut == 'C_CREATED' or $commande->statut == 'C_REGISTERED')
						<a class="btn btn-primary btn-xs" href="#overlay"  onClick="javascript:editCommande({{ $commande->id }}, {{ $commande->Livraison->id }});$('#change_detected').addClass('hidden');" >Modifier cette commande</a>
						<a class="btn btn-danger btn-xs" onClick="javascript:alert('Fonctionnalité souhaitée ??');" >Annuler cette commande</a>
					@else
						<a class="btn btn-warning btn-xs" onClick="javascript:alert('Fonctionnalité souhaitée ??');" >Pour tout changement, contacter le gestionnaire</a>
                    @endif
				</td>
				<td colspan="2">
					TOTAL :
				</td>
				<td>
					@prixFR($commande->montant_total)
				</td>
			</tr>
		</tbody>
	</table>
	<div>
		Relais : {{ $commande->relais->nom }} – Paiement par {{ $commande->modepaiement->nom }}<br />
	</div>