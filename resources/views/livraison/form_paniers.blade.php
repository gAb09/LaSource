@section('modal')
@include('livraison.form_paniers_modale')
@show

<h4 class="col-md-2">Les paniers</h4>

<div id="lescolis" class="col-md-8" style="background-color:#CCE">
	<p class="flexcontainer" style="justify-content:space-between">
		<span>sqsqsqq</span>	
		<span>sqsqsqq</span>	
		<span>sqsqsqq</span>	
		<button type="button" class="btn btn-warning btn-xs">
			<i class="fa fa-btn fa-unlink"></i>Délier ce panier
		</button>
	</p>
	<p class="flexcontainer" style="justify-content:space-between">
		<span>sqsqsqq</span>	
		<span>sqsqsqq</span>	
		<span>sqsqsqq</span>	
		<button type="button" class="btn btn-warning btn-xs">
			<i class="fa fa-btn fa-unlink"></i>Délier ce panier
		</button>
	</p>
	<p class="flexcontainer" style="justify-content:space-between">
		<span>sqsqsqq</span>	
		<span>sqsqsqq</span>	
		<span>sqsqsqq</span>	
		<button type="button" class="btn btn-warning btn-xs">
			<i class="fa fa-btn fa-unlink"></i>Délier ce panier
		</button>
	</p>
</div>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
	<i class="fa fa-btn fa-shopping-basket"></i>Choisir parmi les paniers
</button>

