<div id="dash_rapports_producteurs">
	<h3>Producteurs concernés</h3>

	<table class="producteur" style="width:100%">
	<thead>
		<tr>
			<th class="exploitation">Exploitation</th>
			<th class="exploitation">Paniers</th>
		</tr>
	</thead>

	@foreach($producteurs as $producteur)
	<tr>
			<td class="exploitation">{{$producteur->exploitation}}</th>
	</tr>
	@endforeach
</table>
</div>