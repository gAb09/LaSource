<div id="dash_rapports_relais">
	<h3>Relais concernés</h3>

	<table class="relai" style="width:100%">
	<thead>
		<tr>
			<th class="nom">Ville</th>
			<th class="nom">Relais</th>
		</tr>
	</thead>

	@foreach($relais as $relai)
	<tr>
			<th class="nom">{{$relai->ville}}</th>
			<th class="nom">{{$relai->nom}}</th>
	</tr>
	@endforeach
</table>
</div>