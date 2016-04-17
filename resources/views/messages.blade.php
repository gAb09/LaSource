<div id="messages" class="span12 messages">
	<i id="icoshowmessages" class="icoshowmessages iconemedium hidden" onClick="javascript:montrer(this)"> </i>


	<!-- Messages d'erreurs via Errors -->
	@if($errors->all())
	<div class="alert alert-danger">
		<ul class="errors">
			@foreach($errors->all() as $message)
			<li>{{ $message }}</li>
			@endforeach
		</ul>
	</div>
	@endif

	<!-- Messages d'erreurs via session -->
	@if(Session::get('erreur'))
	<div class="alert alert-danger">
		<p>{{ Session::get('erreur') }}</p>
	</div>
	@endif


	<!-- Messages de succès via session -->
	@if(Session::get('success'))
	<div class="alert alert-success">
		<p>{{ Session::get('success') }}</p>
	</div>
	@endif

	<!-- Messages de succès via session -->
	@if(Session::get('info'))
	<div class="alert alert-info" >
		<p>{{ Session::get('info') }}</p>
	</div>
	@endif
		<i id="icohidemessages" class="icohidemessages iconemedium" onClick="javascript:masquer(this)"> </i>
</div>

<script type="text/javascript">
</script>