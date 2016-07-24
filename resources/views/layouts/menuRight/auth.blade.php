<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
		{{Auth::user()->pseudo }} <span class="caret"></span>
	</a>

	<ul class="dropdown-menu" role="menu">
		<li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Deconnexion</a></li>
		<li><a href="{{ URL::route('client.edit', Auth::user()->id) }}">Modifier mes coordonnées</a></li>
	</ul>
</li>
