@if(Auth::user()->role_id == 3)
Désolés ! Vous n’avez les droits d'accès qu'au prévisionnel !
@else
<div class="nav-collapse collapse">
	<ul class="nav">

		@foreach($sections as $section)
		@if($section->role_id >= Auth::user()->role_id or $section->role_id == 0)

		@if ($section->route == Request::path())
		<li class ="active">
			@else
			<li>
				@endif
				<a href="{{ URL::to($section->route) }}"> {{ $section->etiquette }}</a>
			</li>
			@endif
			@endforeach
		</ul>
	</div>
@endif
