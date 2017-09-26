@section('body')
onLoad="toggle_publication();"
@stop

<!-- Etiquette - Nom système - Route -->
<fieldset>
	<!-- Etiquette -->
	<div class="input">
{{ Form::label('etiquette', 'Étiquette', array ('class' => '')) }}
{{ Form::text('etiquette', null, array('class' => '')) }}
	</div>

	<!-- Nom système -->
	<div class="input nobr">
{{ Form::label('nom_sys', 'Nom système', array ('class' => '')) }}
{{ Form::text('nom_sys', null, array ('class' => 'from')) }}
	</div>

	<!-- Route -->
	<div class="input nobr">
{{ Form::label('route', 'Route', array ('class' => '')) }}
{{ Form::text('route', null, array ('class' => '')) }}
	</div>
</fieldset>

<!-- Parent - Rang - Publication -->
<fieldset>
	<!-- Parent -->
	<div class="input">
{{ Form::label('parent_id', 'Menu parent', array ('class' => '')) }}
{{ Form::select('parent_id', $list_menus, $menu->parent_id) }}
	</div>

	<!-- Rang -->
	<div class="input nobr">
{{ Form::label('rang', 'Rang', array ('class' => '')) }}
{{ Form::text('rang', null, array ('class' => 'input-mini')) }}
	</div>

	<!-- Publication -->
	<div class="input nobr">
		{{ Form::label('publication', '', array ('class' => 'nobr', 'id' => 'publication')) }}
		{{ Form::checkbox('publication', 1, $menu->publication, array ('class' => 'nobr', 'id' => 'publication_check', 'onChange' => 'javascript:toggle_publication()')) }}
	</div>
</fieldset>

	<!-- Role -->
<fieldset>
{{ Form::label('role_id', 'Role associé', array ('class' => '')) }}
{{ Form::select('role_id', $list_roles, $menu->role_id, array ('class' => '')) }}
</fieldset>

	<!-- Description -->
<fieldset>
{{ Form::label('description', 'Description (facultative)', array ('class' => '')) }}
{{ Form::textarea('description', null, array ('class' => '')) }}
</fieldset>



@section('script')
<script src="/assets/js/menus.js">
</script>
@stop


