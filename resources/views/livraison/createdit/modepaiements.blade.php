<div>
	<h4 class="SsTitre">Les relais</h4>
</div>

@forelse($relaiss as $relais)
	<div class="relaiscontainer {{$relais->indisponibilited}}">
	<p>{{ $relais->ville }}<br/>
	{{ $relais->nom }}<br/>
	{{ $relais->tel }}<br/>
	{{ $relais->email }}</p>
		@forelse($relais->indisponibilites as $indisponibilite)
			<p class="cause" style="margin:-5px">Fermé pour cause de</p>
			<p class="cause">{{ $indisponibilite->cause }}<br />
			du {{ $indisponibilite->date_debut_enclair }}<br />au {{ $indisponibilite->date_fin_enclair }}</p>
		@empty
		@endforelse
	@if(!$relais->indisponibilited == 'indisponibilited')
		INPUT
	@endif
	</div>
@empty
	No relais
@endforelse

<div>
	<button type="submit" class="btn btn-sm btn-success">
		<i class="fa fa-btn fa-save fa-lg"></i>Valider ces relais
	</button>
</div>