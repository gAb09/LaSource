<tr 
class=""
id="row_{{ $item->id }}" 
onDblClick="javascript:edit(this, {{ $item->id }});"
>

	<!-- id -->
	<td>
		{{ $item->id }}
	</td>

	<!-- date_cloture -->
	<td>
		{!! $item->cloture !!}
	</td>

	<!-- date_paiement -->
	<td>
		{!! $item->paiement !!}
    @if ($errors->has('date_paiement'))
    <span class="help-block">
        <strong>{{ $errors->first('date_paiement') }}</strong>
    </span>
    @endif
	</td>

	<!-- date_livraison -->
	<td>
		{!! $item->livraison !!}
	</td>


</tr>
